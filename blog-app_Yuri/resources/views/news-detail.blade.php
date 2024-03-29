<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('partials.head')
    <body>
        @include('partials.menu')
        <main class="container">
          <div class="p-4 p-md-5 mb-4 rounded text-bg-dark">
            <div class="col-md-12 px-0">
              <h1 class="display-4 fst-italic">{{ $news->title }}</h1>
            </div>
          </div>

          <div class="row">
            <div class="col-md-4">
                <img class="bd-placeholder-img" width="200" height="250" src="{{ $news->image_url }}">
            </div>
            <div class="col-md-8">
                <p class="card-text mb-auto">{{ $news->text }} </p>
            </div>
          </div>
          <div class="row">
            <p class="h3" style="text-align: center; margin-top:20px;">Comments</p>
            @if(Session::get('logged'))
            <div class="col-md-12">
              <form id="new-comment">
                @csrf()
                <input type="text" name="comment" class="form-control">
                <div class="row justify-content-md-center">
                  <input type="submit" value="Send" class="form-control" style="width:200px;">
                </div>
              </form>
              <form id="new-like">
                @csrf()
                @if (true)
                    <input type="checkbox" name="like" onchange="document.getElementById('new-like').submit()">
                @endif
              </form>
            </div>
            @endif
            <div id="likes-container">

            </div>
            <div id="comments-container">
            
            </div>
          </div>
        </main>

        <div class="toast-container position-fixed bottom-0 end-0 p-3">
          <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
              <strong class="me-auto" id="toast-title">Bootstrap</strong>
              <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body" id="toast-body">
            </div>
          </div>
        </div>

        @include('partials.footer')
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
        @if(Session::get('logged'))
        <script>
          (() => {
            //--------------COMMENT-------------------
            let commentForm = document.getElementById("new-comment");

            commentForm.addEventListener("submit", (e) => {

              e.preventDefault();

              const formData = new FormData(commentForm);

              fetch("{{ route('new-comment', $news->id) }}", {
                method: "POST",
                body: formData,
              })
                .then((response) => response.json())
                .then((result) => {
                  console.log("Success:", result);
                })
                .catch((error) => {
                  console.error("Error:", error);
                });

            });

            //--------------LIKE-------------------
            let likeForm = document.getElementById("new-like");
            
            likeForm.addEventListener("submit", (e2) => {

              e2.preventDefault();

              const formData = new FormData(likeForm);

              fetch("{{ route('new-like', $news->id) }}", {
                method: "POST",
                body: formData,
              })
                .then((response) => response.json())
                .then((result) => {
                  console.log("Success:", result);
                })
                .catch((error) => {
                  console.error("Error:", error);
                });

            });
          })();
        </script>
        @endif
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
        <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
        <script>

          var app_id = "1562027"
          var app_key = "9ec07a7ca8830c5cf206"
          var app_secret = "2341ade26353b8bbb016"
          var app_cluster = "eu"

          function getComments() {

            fetch("{{ route('news-comments', $news->id) }}")
              .then((response) => response.json())
              .then((comments) => {

                let container = document.getElementById('comments-container');

                container.innerHTML = "";

                for(let i = 0; i < comments.length; i++) {
                  let html = '<div class="col-md-12">' +
                    '<div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">' +
                      '<div class="col p-4 d-flex flex-column position-static">' +
                        '<strong class="d-inline-block mb-2 text-primary"><strong>' + comments[i].user.name + '</strong>' +
                        '<div class="mb-1 text-muted">' + comments[i].humanDate + '</div>' +
                        '<p>' + comments[i].comment + '</p>' +
                      '</div>' +
                    '</div>' +
                  '</div>';

                  container.innerHTML += html;
                }
              });
          }

          //------------------LIKE---------------------

          function getLikes() {

          fetch("{{ route('news-likes', $news->id) }}")
            .then((response) => response.json())
            .then((likes) => {
              console.log(likes);
              let container = document.getElementById('likes-container');
        throw new Error("likes: " + likes)
              container.innerHTML = "LIKES: " + likes;

              // for(let i = 0; i < comments.length; i++) {
              //   let html = '<div class="col-md-12">' +
              //     '<div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">' +
              //       '<div class="col p-4 d-flex flex-column position-static">' +
              //         '<strong class="d-inline-block mb-2 text-primary"><strong>' + comments[i].user.name + '</strong>' +
              //         '<div class="mb-1 text-muted">' + comments[i].humanDate + '</div>' +
              //         '<p>' + comments[i].comment + '</p>' +
              //       '</div>' +
              //     '</div>' +
              //   '</div>';

              //   container.innerHTML += html;
              // }
            });
          }

          // Enable pusher logging - don't include this in production
          Pusher.logToConsole = true;

          var pusher = new Pusher(app_key, {
            cluster: app_cluster
          });

          var channel = pusher.subscribe('post-{{ $news->id }}');

          channel.bind('new-comment', function(data) {

            Toastify({
              text: data.user_name + " ha scritto: " + data.comment,
              duration: 3000,
              gravity: "bottom", // `top` or `bottom`
              position: "right", // `left`, `center` or `right`
              stopOnFocus: true, // Prevents dismissing of toast on hover
              style: {
                background: "linear-gradient(to right, #00b09b, #96c93d)",
              },
              onClick: function(){} // Callback after click
            }).showToast();

            getComments();
          });

          getComments();

          channel.bind('new-like', function(data) {

            Toastify({
              text: "",
              duration: 3000,
              gravity: "bottom", // `top` or `bottom`
              position: "right", // `left`, `center` or `right`
              stopOnFocus: true, // Prevents dismissing of toast on hover
              style: {
                background: "linear-gradient(to right, #ffb09b, #96c93d)",
              },
              onClick: function(){} // Callback after click
            }).showToast();

            getLikes();
            });

            getLikes();
        </script>
    </body>
</html>
