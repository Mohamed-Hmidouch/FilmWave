<div class="border-t border-[#333] py-4 comment-item" id="comment-{{ $comment->id }}">
    <div class="flex items-start gap-3">
        <div class="w-10 h-10 rounded-full overflow-hidden flex-shrink-0">
            <img src="https://ui-avatars.com/api/?name={{ substr($comment->user->name ?? 'U', 0, 1) }}&background=E50914&color=fff" alt="Avatar" class="w-full h-full object-cover">
        </div>
        <div class="flex-grow">
            <div class="flex items-center justify-between">
                <div>
                    <span class="font-medium">{{ $comment->user->name ?? 'Utilisateur' }}</span>
                    <span class="text-gray-500 text-sm ml-2">{{ $comment->created_at->diffForHumans() }}</span>
                </div>
                @auth
                    @if(Auth::id() === $comment->user_id)
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="text-gray-500 hover:text-white">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 bg-[#242424] rounded shadow-lg z-10 py-1 w-32">
                            <button 
                                type="button" 
                                class="w-full text-left px-4 py-2 text-sm text-gray-300 hover:bg-[#333]"
                                @click="open = false; document.getElementById('edit-comment-{{ $comment->id }}').classList.toggle('hidden')"
                            >
                                <i class="fas fa-edit mr-2"></i> Modifier
                            </button>
                            <form action="{{ route('comments.destroy', $comment->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-300 hover:bg-[#333]">
                                    <i class="fas fa-trash mr-2"></i> Supprimer
                                </button>
                            </form>
                        </div>
                    </div>
                    @endif
                @endauth
            </div>
            <p class="text-gray-300 mt-1">{{ $comment->body }}</p>
            
            <!-- Edit form (hidden by default) -->
            <div id="edit-comment-{{ $comment->id }}" class="hidden mt-3">
                <form action="{{ route('comments.update', $comment->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <textarea 
                        name="body" 
                        class="w-full bg-[#242424] border border-[#333] rounded-md p-3 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-film-red resize-none"
                        rows="2"
                    >{{ $comment->body }}</textarea>
                    <div class="flex justify-end mt-2 gap-2">
                        <button 
                            type="button" 
                            class="bg-[#333] hover:bg-[#444] text-white px-3 py-1 rounded-md transition-colors"
                            onclick="document.getElementById('edit-comment-{{ $comment->id }}').classList.add('hidden')"
                        >
                            Annuler
                        </button>
                        <button 
                            type="submit" 
                            class="bg-film-red hover:bg-red-700 text-white px-3 py-1 rounded-md transition-colors"
                        >
                            Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
