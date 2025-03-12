<?php
namespace App\Http\Controllers;

use App\Models\YoutubeVideo;
use App\Models\Playlist;
use Illuminate\Http\Request;
use App\Http\Requests\StoreYoutubeVideoRequest;
use App\Http\Requests\UpdateYoutubeVideoRequest;
class YoutubeVideoController extends Controller
{
    public function index()
    {
        $videos = YouTubeVideo::orderBy('created_at', 'desc')->paginate(15); // Paginate videos (15 per page)
       
        return view('youtube_videos.index', compact('videos'));
    }
    public function search(Request $request)
    {
        $query = $request->get('query');
        $playlistId = $request->get('playlist_id');
    
        // Fetch videos based on query
        $videos = YoutubeVideo::where('title', 'like', "%{$query}%")
        ->orWhere('youtube_url', 'like', "%{$query}%")
        ->get();

        // If it's for a specific playlist, exclude videos already in that playlist
        if ($playlistId) {
            $playlist = Playlist::find($playlistId);
            $existingVideos = $playlist->videos->pluck('id')->toArray();
            $videos = $videos->whereNotIn('id', $existingVideos);
        }
    
        return response()->json($videos);
    }
    
    
    
    public function create()
    {
        return view('youtube_videos.create');
    }

    public function store(StoreYoutubeVideoRequest $request)
    {
        $request->validated();

        YoutubeVideo::create($request->all());

        return redirect()->route('youtube_videos.index')->with('success', 'Video added successfully.');
    }

    public function show(YoutubeVideo $video)
    {
        return view('youtube_videos.show', compact('video'));
    }

    public function edit($id)
{
    $video = YouTubeVideo::findOrFail($id);
    return view('youtube_videos.edit', compact('video'));
}


public function update(UpdateYoutubeVideoRequest $request, $id)
{
    // Find the existing video by ID
    $video = YouTubeVideo::findOrFail($id);

    // Validate the request
    $validatedData = $request->validated();

    // Update the fields
    $video->title = $validatedData['title'];
    $video->youtube_url = $validatedData['youtube_url'];
    $video->description = $validatedData['description'] ?? null;

    // Save the changes
    $video->save();

    return redirect()->route('youtube_videos.index')->with('success', 'Video updated successfully.');
}


    public function destroy($id)
    {
        $video = YouTubeVideo::findOrFail($id);
        $video->delete();
    
        return redirect()->route('youtube_videos.index')->with('success', 'Video successfully deleted');
    }
    
}
