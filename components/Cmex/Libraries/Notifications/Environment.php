<?php

namespace Cmex\Libraries\Notifications;

class Environment
{

    private $model = null;

    public function __construct(Notification $model)
    {
        $this->model = $model;
    }

    public function system($title, $message, $sender = "cmex", $clickaction = "none")
    {
        return $this->user(0, $title, $message, $sender, $clickaction);
    }

    public function user($receiver, $title, $message, $sender = "cmex", $clickaction = "none")
    {
        $data = array(
            'title' => $title,
            'message' => $message,
            'sender' => $sender,
            'clickaction' => $clickaction,
            'receiver_id' => $receiver
        );

        $notification = $this->model->create($data);

        return $notification;
    }

    public function forUser($userid)
    {
        $collection = $this->model->where(
            function ($query) use ($userid) {
                $query->where('receiver_id', '=', 0);
                $query->orWhere('receiver_id', '=', $userid);
            }
        )->whereRaw('created_at = updated_at')->get();


        // $collection = $this->model->where( function($query) {
        //     'receiver_id', '=', 0)
        //                 ->orWhere('receiver_id', '=', $userid)
        //                 ->whereRaw('created_at = updated_at')
        //                 ->get();

        return $collection;
    }

    public function markAllAsReadForUser($userid)
    {

    }

    public function markAsRead($notificationid)
    {

    }

    public function markAllAsRead()
    {
        $collection = $this->model->whereRaw('created_at = updated_at')->get();

        $collection->each(
            function ($notify) {
                $notify->save();
            }
        );

        //$collection->save();

        return true;
    }
}
