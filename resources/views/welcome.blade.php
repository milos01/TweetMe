<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>TweetMe</title>
        <!-- <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" rel="stylesheet"/> -->
        <!-- Styles -->
        <link rel="stylesheet" type="text/css" href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
        <style type="text/css">

            .main_holer{
                margin-top: 40vh;
            }

            .url_input{
                padding-right: 0px; 
            }

            .tweetme_button{
                padding-left: 0px;
            }

            .error-text{
                color: #d9534f;
                
            }

            .error-holder{
                margin-top: -10px;
            }

        </style>
        
    </head>
    <body>
        <div class="row justify-content-center">
            <div class="col-md-5 text-center main_holer">
                <div class="title m-b-md text-left">
                    Enter tweet url here
                </div>
                <form method="GET" action="{{ route('findTweet') }}">
                    <div class="form-group {{ $errors->has('tweet_url') ? 'has-danger' : '' }}">
                    <div class="row">
                       
                            <div class="col-md-10 url_input">
                                <input class="form-control" type="text" name="tweet_url" placeholder="Enter url">
                            </div>
                            <div class="col-md-2 tweetme_button">
                                <button class="btn btn-primary" type="submit">Tweet me!</button>
                            </div>
                            
                        
                    </div>
                    
                    </div>

                </form>
                @if ($errors->has('tweet_url'))
                <div class="text-left error-holder">
                    <span class="error-text"><strong>{{ $errors->first('tweet_url') }}</strong></span>
                </div>    
                @endif
            </div>
        </div>

        <!-- JavaScript -->
        <script type="text/javascript" src="{{ asset('bower_components/popper.js/dist/umd/popper.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('bower_components/jquery/dist/jquery.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    </body>
</html>
