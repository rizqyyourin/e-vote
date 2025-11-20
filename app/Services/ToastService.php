<?php

namespace App\Services;

class ToastService
{
    public static function success($message)
    {
        session()->flash('toast', [
            'message' => $message,
            'type' => 'success'
        ]);
    }

    public static function error($message)
    {
        session()->flash('toast', [
            'message' => $message,
            'type' => 'error'
        ]);
    }

    public static function info($message)
    {
        session()->flash('toast', [
            'message' => $message,
            'type' => 'info'
        ]);
    }
}
