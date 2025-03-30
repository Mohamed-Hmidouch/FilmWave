@extends('app')

@section('content')
<!-- Filter Bar -->
<div class="filter-bar mb-4">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <ul class="nav nav-pills justify-content-center">
                    <li class="nav-item mx-2">
                        <a class="nav-link active" href="#">New Films</a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link" href="#">Last Episode</a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link" href="#">Last Series</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Series Grid -->
<div class="series-container">
    <div class="container">
        <div class="row">
            <!-- Series Card 1 -->
            <div class="col-md-4 col-lg-3 mb-4">
                <div class="card series-card">
                    <img src="https://via.placeholder.com/300x450" class="card-img-top" alt="Stranger Things">
                    <div class="card-body">
                        <h5 class="card-title">Stranger Things</h5>
                        <p class="card-text">Episode 8</p>
                        <p class="card-text"><small class="text-muted">Released: January 15, 2023</small></p>
                    </div>
                </div>
            </div>
            
            <!-- Series Card 2 -->
            <div class="col-md-4 col-lg-3 mb-4">
                <div class="card series-card">
                    <img src="https://via.placeholder.com/300x450" class="card-img-top" alt="The Witcher">
                    <div class="card-body">
                        <h5 class="card-title">The Witcher</h5>
                        <p class="card-text">Episode 5</p>
                        <p class="card-text"><small class="text-muted">Released: February 20, 2023</small></p>
                    </div>
                </div>
            </div>
            
            <!-- Series Card 3 -->
            <div class="col-md-4 col-lg-3 mb-4">
                <div class="card series-card">
                    <img src="https://via.placeholder.com/300x450" class="card-img-top" alt="Breaking Bad">
                    <div class="card-body">
                        <h5 class="card-title">Breaking Bad</h5>
                        <p class="card-text">Episode 10</p>
                        <p class="card-text"><small class="text-muted">Released: March 5, 2023</small></p>
                    </div>
                </div>
            </div>
            
            <!-- Series Card 4 -->
            <div class="col-md-4 col-lg-3 mb-4">
                <div class="card series-card">
                    <img src="https://via.placeholder.com/300x450" class="card-img-top" alt="Game of Thrones">
                    <div class="card-body">
                        <h5 class="card-title">Game of Thrones</h5>
                        <p class="card-text">Episode 6</p>
                        <p class="card-text"><small class="text-muted">Released: April 12, 2023</small></p>
                    </div>
                </div>
            </div>
            
            <!-- Series Card 5 -->
            <div class="col-md-4 col-lg-3 mb-4">
                <div class="card series-card">
                    <img src="https://via.placeholder.com/300x450" class="card-img-top" alt="Money Heist">
                    <div class="card-body">
                        <h5 class="card-title">Money Heist</h5>
                        <p class="card-text">Episode 3</p>
                        <p class="card-text"><small class="text-muted">Released: May 8, 2023</small></p>
                    </div>
                </div>
            </div>
            
            <!-- Series Card 6 -->
            <div class="col-md-4 col-lg-3 mb-4">
                <div class="card series-card">
                    <img src="https://via.placeholder.com/300x450" class="card-img-top" alt="The Crown">
                    <div class="card-body">
                        <h5 class="card-title">The Crown</h5>
                        <p class="card-text">Episode 9</p>
                        <p class="card-text"><small class="text-muted">Released: June 18, 2023</small></p>
                    </div>
                </div>
            </div>
            
            <!-- Series Card 7 -->
            <div class="col-md-4 col-lg-3 mb-4">
                <div class="card series-card">
                    <img src="https://via.placeholder.com/300x450" class="card-img-top" alt="The Boys">
                    <div class="card-body">
                        <h5 class="card-title">The Boys</h5>
                        <p class="card-text">Episode 4</p>
                        <p class="card-text"><small class="text-muted">Released: July 22, 2023</small></p>
                    </div>
                </div>
            </div>
            
            <!-- Series Card 8 -->
            <div class="col-md-4 col-lg-3 mb-4">
                <div class="card series-card">
                    <img src="https://via.placeholder.com/300x450" class="card-img-top" alt="Ozark">
                    <div class="card-body">
                        <h5 class="card-title">Ozark</h5>
                        <p class="card-text">Episode 7</p>
                        <p class="card-text"><small class="text-muted">Released: August 30, 2023</small></p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Pagination -->
        <div class="row">
            <div class="col-12 d-flex justify-content-center mt-4">
                <nav>
                    <ul class="pagination">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                        </li>
                        <li class="page-item active" aria-current="page">
                            <a class="page-link" href="#">1</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">2</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">3</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
@endsection