<?php

namespace App\Http\Controllers;

use App\Thread;
use App\Reply;
use App\Http\Requests\CreatePostRequest;
use Illuminate\Support\Facades\Gate;

class RepliesController extends Controller
{
    /**
     * Create a new RepliesController instance.
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => 'index']);
    }

    /**
     * get all of the reply
     *
     * @param  integer $channelId
     * @param  Thread  $thread
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index($channelId, Thread $thread)
    {
        return response($thread->replies()->paginate(20), 200);
    }

    /**
     * Persist a new reply.
     *
     * @param  Spam     $spam
     * @param  integer $channelId
     * @param  Thread  $thread
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store($channelId, Thread $thread, CreatePostRequest $form)
    {
        if ($thread->locked) {
            return response('Thread is locked', 422);
        }

        return $reply = $thread->addReply([
            'body' => request('body'),
            'user_id' => auth()->id()
        ])
        ->load('owner');
    }

    /**
     * destroy a reply
     *
     * @param  Reply  $reply
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Reply $reply)
    {
        $this->authorize('update', $reply);

        $reply->delete();

        if (request()->expectsJson()) {
            return response(['status' => 'reply deleted']);
        }

        return back();
    }

    /**
     * update a reply
     *
     * @param  Reply  $reply
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Reply $reply)
    {
        $this->authorize('update', $reply);

        $this->validate(request(), ['body' => 'required|spamfree']);

        $reply->update(request(['body']));
    }
}
