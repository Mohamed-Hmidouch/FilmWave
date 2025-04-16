<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Series;
use App\Models\Episode;
use App\Models\Movie;

class VideoPlayerController extends BaseController
{
    /**
     * Afficher la page de visionnage d'un épisode d'une série
     *
     * @param  int  $seriesId
     * @param  int  $episodeId
     * @return \Illuminate\View\View
     */
    public function watchEpisode($seriesId, $episodeId = null)
    {
        // Données statiques pour l'affichage
        $series = (object)[
            'id' => $seriesId,
            'title' => 'Stranger Things',
            'poster' => 'https://image.tmdb.org/t/p/w500/56v2KjBlU4XaOv9rVYEQypROD7P.jpg',
            'description' => 'À Hawkins, dans l\'Indiana, un groupe d\'amis se lance dans une quête pour comprendre les phénomènes étranges qui se produisent dans leur ville, notamment la disparition de leur ami Will Byers.',
            'release_year' => '2016',
            'age_rating' => '16+',
            'seasons' => collect([1, 2, 3, 4])
        ];

        $episode = (object)[
            'id' => $episodeId ?? 1,
            'title' => 'Chapitre Un: La disparition de Will Byers',
            'season' => 1,
            'episode_number' => 1,
            'thumbnail' => 'https://image.tmdb.org/t/p/w500/AdwF73eLm25h8bKeKaMZVXBk8wc.jpg',
            'video_url' => 'https://example.com/stranger-things-s01e01.mp4',
            'description' => 'La disparition d\'un jeune garçon fait remonter à la surface d\'anciens souvenirs et déclenche d\'étranges événements dans une petite ville.',
            'duration' => 48
        ];

        $nextEpisode = (object)[
            'id' => 2,
            'title' => 'Chapitre Deux: La folle de Maple Street',
            'season' => 1,
            'episode_number' => 2
        ];

        $seasons = [1, 2, 3, 4];

        $seasonEpisodes = collect([
            (object)[
                'id' => 1,
                'title' => 'Chapitre Un: La disparition de Will Byers',
                'episode_number' => 1,
                'duration' => 48
            ],
            (object)[
                'id' => 2,
                'title' => 'Chapitre Deux: La folle de Maple Street',
                'episode_number' => 2,
                'duration' => 50
            ],
            (object)[
                'id' => 3,
                'title' => 'Chapitre Trois: Holly, Jolly',
                'episode_number' => 3,
                'duration' => 52
            ],
            (object)[
                'id' => 4,
                'title' => 'Chapitre Quatre: Le corps',
                'episode_number' => 4,
                'duration' => 49
            ],
            (object)[
                'id' => 5,
                'title' => 'Chapitre Cinq: La puce et l\'acrobate',
                'episode_number' => 5,
                'duration' => 51
            ]
        ]);

        return view('watch.episode', compact('series', 'episode', 'nextEpisode', 'seasons', 'seasonEpisodes'));
    }

    /**
     * Afficher la page de visionnage d'un film
     *
     * @param  int  $movieId
     * @return \Illuminate\View\View
     */
    public function watchMovie($movieId)
    {
        // Données statiques pour l'affichage
        $movie = (object)[
            'id' => $movieId,
            'title' => 'Inception',
            'poster' => 'https://image.tmdb.org/t/p/w500/edv5CZvWj09upOsy2Y6IwDhK8bt.jpg',
            'description' => 'Dom Cobb est un voleur expérimenté, le meilleur dans l\'art dangereux de l\'extraction, voler les secrets les plus intimes enfouis au plus profond du subconscient pendant que l\'esprit de la cible est vulnérable.',
            'release_year' => '2010',
            'duration' => 148,
            'age_rating' => '12+',
            'rating' => 8.8,
            'director' => 'Christopher Nolan',
            'writer' => 'Christopher Nolan',
            'video_url' => 'https://example.com/inception.mp4',
            'categories' => collect([
                (object)['name' => 'Science-Fiction'],
                (object)['name' => 'Action'],
                (object)['name' => 'Thriller']
            ]),
            'actors' => collect([
                (object)[
                    'name' => 'Leonardo DiCaprio',
                    'photo' => 'https://image.tmdb.org/t/p/w500/wo2hJpn04vbtmh0B9utCFdsQhxM.jpg',
                    'pivot' => (object)['character_name' => 'Dom Cobb']
                ],
                (object)[
                    'name' => 'Joseph Gordon-Levitt',
                    'photo' => 'https://image.tmdb.org/t/p/w500/4U9G4YwTlIEbAymBaseltS38eH2.jpg',
                    'pivot' => (object)['character_name' => 'Arthur']
                ],
                (object)[
                    'name' => 'Ellen Page',
                    'photo' => 'https://image.tmdb.org/t/p/w500/gJ1hYRQIMpMBBWWJrxkOYNZ1JeR.jpg',
                    'pivot' => (object)['character_name' => 'Ariadne']
                ],
                (object)[
                    'name' => 'Tom Hardy',
                    'photo' => 'https://image.tmdb.org/t/p/w500/4W8V45lVe9l8hV60SgYQDQrrqL8.jpg',
                    'pivot' => (object)['character_name' => 'Eames']
                ]
            ])
        ];

        $similarMovies = collect([
            (object)[
                'id' => 2,
                'title' => 'Interstellar',
                'poster' => 'https://image.tmdb.org/t/p/w500/gEU2QniE6E77NI6lCU6MxlNBvIx.jpg',
                'release_year' => '2014',
                'duration' => 169
            ],
            (object)[
                'id' => 3,
                'title' => 'The Matrix',
                'poster' => 'https://image.tmdb.org/t/p/w500/f89U3ADr1oiB1s9GkdPOEpXUk5H.jpg',
                'release_year' => '1999',
                'duration' => 136
            ],
            (object)[
                'id' => 4,
                'title' => 'Tenet',
                'poster' => 'https://image.tmdb.org/t/p/w500/k68nPLbIST6NP96JmTxmZijEvCA.jpg',
                'release_year' => '2020',
                'duration' => 150
            ],
            (object)[
                'id' => 5,
                'title' => 'Shutter Island',
                'poster' => 'https://image.tmdb.org/t/p/w500/kve20tXwUZpu4GUX8l6X7Z4jmL6.jpg',
                'release_year' => '2010',
                'duration' => 138
            ],
            (object)[
                'id' => 6,
                'title' => 'Memento',
                'poster' => 'https://image.tmdb.org/t/p/w500/yuNs09hvpHVU1cBTCAk9zxsL2oW.jpg',
                'release_year' => '2000',
                'duration' => 113
            ],
            (object)[
                'id' => 7,
                'title' => 'The Prestige',
                'poster' => 'https://image.tmdb.org/t/p/w500/5MlvT4Y0F3jR2zOyTdkjXrGS7vH.jpg',
                'release_year' => '2006',
                'duration' => 130
            ]
        ]);

        return view('watch.movie', compact('movie', 'similarMovies'));
    }

    /**
     * Télécharger un épisode de série
     *
     * @param int $seriesId
     * @param int $episodeId
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function downloadEpisode($seriesId, $episodeId)
    {
        // Pour cette version statique, on va simplement simuler un téléchargement
        // Dans la version dynamique, on récupèrerait le vrai fichier depuis le stockage
        
        // Normalement, on enregistrerait un téléchargement dans la base de données
        // Log::info("Téléchargement de l'épisode $episodeId de la série $seriesId");

        // Dans une application réelle, on ferait:
        // $episode = Episode::findOrFail($episodeId);
        // $filePath = storage_path('app/public/' . $episode->file_path);
        // return response()->download($filePath, "episode-{$episode->season_number}-{$episode->episode_number}.mp4");
        
        // Redirection temporaire (pour version statique)
        return redirect()->back()->with('info', 'Téléchargement simulé. Cette fonctionnalité sera disponible dans la version finale.');
    }

    /**
     * Télécharger un film
     *
     * @param int $movieId
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function downloadMovie($movieId)
    {
        // Pour cette version statique, on va simplement simuler un téléchargement
        // Dans la version dynamique, on récupèrerait le vrai fichier depuis le stockage
        
        // Normalement, on enregistrerait un téléchargement dans la base de données
        // Log::info("Téléchargement du film $movieId");

        // Dans une application réelle, on ferait:
        // $movie = Movie::findOrFail($movieId);
        // $content = $movie->content;
        // $contentFile = $content->contentFiles()->first();
        // $filePath = storage_path('app/public/' . $contentFile->file_path);
        // return response()->download($filePath, "{$movie->title}.mp4");
        
        // Redirection temporaire (pour version statique)
        return redirect()->back()->with('info', 'Téléchargement simulé. Cette fonctionnalité sera disponible dans la version finale.');
    }
} 