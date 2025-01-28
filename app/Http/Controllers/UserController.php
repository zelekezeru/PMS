public function show($id)
{
    $user = User::find($id);

    if (!$user) {
        return redirect()->route('users.index')->with('error', 'User not found.');
    }

    return view('users.show', compact('user'));
}
