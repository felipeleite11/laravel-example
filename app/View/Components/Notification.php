<?php

namespace App\View\Components;

use Exception;
use Illuminate\View\Component;

class Notification extends Component
{
    protected $except = ['type'];

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($error)
    {
        $data = session('notification');

        if($error->any()) {
            $this->message = $error->first();
            $this->color = $this->defineColor('error');
        } else if(isset($data)) {
            $this->message = $data['message'];
            $this->color = $this->defineColor($data['type'] ?: 'info');
        }
    }

    private function defineColor($type) {
        switch($type) {
            case 'error': return 'red';
            case 'success': return 'green';
            case 'info': return 'blue';
            case 'warn': return 'yellow black-text';
            default: throw new Exception('Undefined notification type [app/View/Components/Notification.php].');
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return isset($this->message) ?
            view('components.notification', [
                'message' => $this->message,
                'color' => $this->color
            ]) : null;
    }
}
