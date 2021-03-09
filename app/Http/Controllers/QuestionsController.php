<?php

namespace App\Http\Controllers;

use App\Question;
use App\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\QuestionsRepository;

class QuestionsController extends Controller
{
    protected $questionsRepository;

    public function __construct(QuestionsRepository $questionsRepository)
    {
        $this->middleware('auth')->except(['index', 'show']);
        $this->questionsRepository = $questionsRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = Question::query()->published()->with(['user','answers'])->latest('updated_at')->paginate(15);

        return view('questions.index', compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('questions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $request->validate([
            'title' => 'required|min:5|max:255',
            'body' => 'required'
        ]);
        $topics = $this->questionsRepository->normalizeTopic($request->get('topics'));
        $data = [
            'title' => $request->title,
            'body' => $request->body,
            'user_id' => Auth::id(),
        ];
        $questions = $this->questionsRepository->create($data);
        $questions->topics()->attach($topics);
        return redirect()->route('questions.show', [$questions->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $question = $this->questionsRepository->byIdWithTopics($id);
        return view('questions.show', compact('question'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $question = $this->questionsRepository->byId($id);
        if (Auth::user()->owns($question)) {
            return view('questions.edit', compact('question'));
        }
        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|min:5|max:255',
            'body' => 'required'
        ]);
        $question = $this->questionsRepository->byId($id);
        $question->update([
            'title' => $request->title,
            'body' => $request->body,
        ]);
        $question->topics()->sync($this->questionsRepository->normalizeTopic($request->topics));

        return redirect()->route('questions.show', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $this->questionsRepository->destroy($id);
        return redirect()->route('questions.index')->with('success','删除成功!');
    }


}
