<?php

namespace App\Http\Livewire;

use App\Models\Comment as ModelsComment;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Intervention\Image\Facades\Image as Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Comment extends Component
{

    use WithPagination;
    use WithFileUploads;

    public $newComment;
    public $image;
    // public $comments;

    protected $listeners = ['fileUpload' => 'handleFileUpload'];
    public function handleFileUpload($imageData)
    {
        $this->image = $imageData;
    }



    public function render()
    {
        return view('livewire.comment', ['comments' =>  ModelsComment::latest()->paginate(2)]);
    }

    // public function mount()
    // {
    //     dd($initialComments);
    //     $initialComments = ModelsComment::all();
    //     $initialComments = ModelsComment::latest()->get();
    //     $this->comments = $initialComments;
    // }

    // public function mount($initialComment) {
    //     $this->comments = $initialComments;

    // }


    public function updated($field) //FOR LIVEWIRE REAL TIME VALIDATION
    {
        $this->validateOnly($field, ['newComment' => 'required|max:255']);
    }

    public function handleAddComment()
    {

        // $this->comments[] = [
        //     'body' => 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Adipisci velit aliquid sapiente magni ab ducimus eius saepe esse est neque?',
        //     'created_at' => '1 mins ago',
        //     'creator' => 'Jayson'
        // ];

        // array_unshift($this->comments, [
        //     'body' => $this->newComment,
        //     'created_at' => Carbon::now()->diffForHumans(),
        //     'creator' => 'Jayson'
        // ]);

        // if (!$this->newComment) {
        //     return;
        // }

        $this->validate(['newComment' => 'required|max:255']);
        $image = $this->storeImage();

        ModelsComment::create([
            'body' => $this->newComment, 'user_id' => 1,
            'image' => $image
        ]);
        // $this->comments->push($createdComment);
        // $this->comments->prepend($createdComment);
        $this->newComment = "";
        $this->image = "";
        session()->flash('message', 'Comment successfully added.');
    }


    public function storeImage()
    {
        if (!$this->image) {
            return null;
        }

        $img = Image::make($this->image)->encode('jpg');
        $name = Str::random() . '.jpg';
        Storage::disk('public')->put($name, $img);

        return $name;
    }

    public function handleRemoveComment($commentID)
    {
        $comment = ModelsComment::find($commentID);
        if ($comment->image) {
            Storage::disk('public')->delete($comment->image);
        }
        $comment->delete();
        // $this->comments = $this->comments->except($commentID);
        session()->flash('message', 'Comment successfully deleted.');

        // $this->comments = $this->comments->where('id', '!=', $commentID);
        // dd($comment);
    }
}
