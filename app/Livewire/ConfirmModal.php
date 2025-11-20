<?php

namespace App\Livewire;

use Livewire\Component;

class ConfirmModal extends Component
{
    public $title = '';
    public $message = '';
    public $confirmText = 'Confirm';
    public $cancelText = 'Cancel';
    public $actionMethod = '';
    public $actionParams = [];
    public $open = false;

    public function confirm()
    {
        if ($this->actionMethod && $this->actionParams) {
            $this->call($this->actionMethod, ...$this->actionParams);
        } elseif ($this->actionMethod) {
            $this->call($this->actionMethod);
        }
        $this->open = false;
    }

    public function close()
    {
        $this->open = false;
    }

    public function showConfirm($title, $message, $actionMethod, $actionParams = [], $confirmText = 'Confirm')
    {
        $this->title = $title;
        $this->message = $message;
        $this->actionMethod = $actionMethod;
        $this->actionParams = $actionParams;
        $this->confirmText = $confirmText;
        $this->open = true;
    }

    public function render()
    {
        return view('livewire.confirm-modal');
    }
}
