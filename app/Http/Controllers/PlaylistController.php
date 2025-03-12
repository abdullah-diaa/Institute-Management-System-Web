<?php
namespace App\Http\Controllers;

use App\Models\Playlist;
use Illuminate\Http\Request;
use App\Http\Requests\StorePlaylistRequest;
use App\Http\Requests\UpdatePlaylistRequest;
class PlaylistController extends Controller
{
    public function index()
    {
       
        $playlists = Playlist::orderBy('created_at', 'desc')->paginate(10); // Paginate playlists (10 per page)
    
        return view('playlists.index', compact('playlists',));
    }
    

    public function create()
    {
        return view('playlists.create');
    }

   public function store(StorePlaylistRequest $request)
{
    $request->validated();

    // Prepare the data for storage
    $data = $request->only(['name', 'description']);
    $data['created_by'] = auth()->id();

    // Handle image upload like the Post method
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension(); // Get the original extension
        $image->storeAs('public/playlist_images', $imageName); // Store image in storage
        $data['image'] = 'playlist_images/' . $imageName; // Save image path to database
    }

    // Create the playlist
    $playlist = Playlist::create($data);

    // Add videos to the playlist
    $videoIds = json_decode($request->input('video_ids'), true);
    if ($videoIds) {
        $playlist->videos()->attach($videoIds);
    }

    return redirect()->route('playlists.index')->with('success', 'Playlist created successfully!');
}

    
    

    public function show($id)
    {
        // Fetch the playlist along with its videos, paginate videos to 10 per page
        $playlist = Playlist::with(['videos'])->findOrFail($id);
    
        // Paginate the videos
        $videos = $playlist->videos()->paginate(10);
    
        // Return the view with playlist and videos data
        return view('playlists.show', compact('playlist', 'videos'));
    }
    

    public function edit(Playlist $playlist)
    {
        return view('playlists.edit', compact('playlist'));
    }

    public function update(UpdatePlaylistRequest $request, Playlist $playlist)
    {
        // Validate the request
        $request->validated();
    
        // Prepare the data for updating
        $data = $request->only(['name', 'description']);
        
        // Handle image update
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension(); // Get the original extension
            $image->storeAs('public/playlist_images', $imageName); // Store image in storage
            $data['image'] = 'playlist_images/' . $imageName; // Save image path to database
        }
        // Update the playlist
        $playlist->update($data);
    
        // Update the associated videos
        $videoIds = json_decode($request->input('video_ids'), true);
    
        if ($videoIds) {
            // Sync the videos with the playlist (removes old ones and adds new ones)
            $playlist->videos()->sync($videoIds);
        } else {
            // If no videos are selected, detach all videos from the playlist
            $playlist->videos()->detach();
        }
    
        // Redirect back to the playlists index with a success message
        return redirect()->route('playlists.index')->with('success', 'Playlist updated successfully!');
    }
    

    public function destroy(Playlist $playlist)
    {
        $playlist->delete();
        return redirect()->route('playlists.index')->with('success', 'Playlist deleted successfully.');
    }
}
