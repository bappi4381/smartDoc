<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Notification\BroadcastNotificationRequest;
use App\Http\Requests\Admin\Notification\NotificationBulkActionRequest;
use App\Services\Admin\AdminNotificationService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class NotificationController extends Controller
{
    public function __construct(
        private readonly AdminNotificationService $notificationService
    ) {
    }

    public function index(Request $request): View
    {
        $notifications = $this->notificationService->paginate(perPage: 25);

        return view('admin.notifications.index', [
            'notifications' => $notifications,
            'unreadCount' => $this->notificationService->unreadCount(),
        ]);
    }

    public function broadcast(BroadcastNotificationRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $scope = $validated['scope'];

        if ($scope === 'all') {
            $this->notificationService->broadcastToAll($validated['title'], $validated['message'], $validated['action_url'] ?? null);
        } elseif ($scope === 'role') {
            $this->notificationService->broadcastToRole($validated['role'], $validated['title'], $validated['message'], $validated['action_url'] ?? null);
        } else {
            $userIds = Collection::make($validated['user_ids'] ?? []);
            $this->notificationService->broadcastToUsers($userIds, $validated['title'], $validated['message'], $validated['action_url'] ?? null);
        }

        return back()->with('status', 'Notification broadcast queued.');
    }

    public function markRead(NotificationBulkActionRequest $request): RedirectResponse
    {
        $this->notificationService->markAsRead($request->validated('notification_ids'));

        return back()->with('status', 'Notifications marked as read.');
    }

    public function destroy(NotificationBulkActionRequest $request): RedirectResponse
    {
        $this->notificationService->delete($request->validated('notification_ids'));

        return back()->with('status', 'Notifications removed.');
    }
}

