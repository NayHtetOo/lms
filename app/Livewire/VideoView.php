<?php

namespace App\Livewire;

use Livewire\Attributes\Computed;
use Livewire\Component;

class VideoView extends Component
{
    public $data;

    public function mount($data){
       $this->data = $data;
    //    $this->videoData();
    }
    public function render()
    {
        return view('livewire.video-view');
    }
    // #[Computed()]
    // public function videoData(){
    //     return $this->data;
    // }
}
