<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{config('app.name')}}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="{!! asset('theme/css/sb-admin-2.min.css') !!}">
  <style>
    body {
      font-family: "Cairo", sans-serif;
      font-optical-sizing: auto;
      font-weight: 400;
      font-style: normal;
      font-variation-settings: "slnt" 0;
      background-color: #f0f0f0;
    }
    footer {
      position: sticky;
      bottom: 0 ;
      width: 100%;
      height: 40px;
      line-height: 40px;
      background-color: black;
      color: white
    }
    li {
      list-style: none
    }
    img {
      border-radius: 50%;
      object-fit: cover;
    }
  </style>
  @yield('style')

  @vite(['resources/css/app.css', 'resources/js/app.js'])
  
  </head>
  <body dir="rtl" style="text-align: right">
    
    <div>
      @include('partials.navbar')

      <main class="py-4 mb-5">
        <div class="container">
          <div class="row">
            @include('alerts.success')

            @yield('content')

            {{-- @include('partials.sidebar') --}}

          </div>
        </div>
      </main>

        @include('partials.footer')
    </div>

    {{-- BOOTSTRAP --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

    {{-- JQUERY --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    
    {{-- PUSHER --}}
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

    <script>
      // Enable pusher logging - don't include this in production
      Pusher.logToConsole = true;
      var pusher = new Pusher('2af0757346df101aaf23', {
        cluster: 'mt1'
      });
      var channel = pusher.subscribe('my-channel');
      channel.bind('my-event', function(data) {
        alert(JSON.stringify(data));
      });
    </script>

    <script type="module">
      @if(Auth::check())
          var post_userId = {{Auth::user()->id}};
          Echo.private(`real-notification.${post_userId}`)
          .listen('CommentNotification', (data) => {
            // console.log(data.post.slug);
              var notificationsWrapper = $('.alert-dropdown');
              var notificationsToggle = notificationsWrapper.find('a[data-bs-toggle]');
              var notificationsCountElem = notificationsToggle.find('span[data-count]');
              var notificationsCount = parseInt(notificationsCountElem.text());
              var notifications = notificationsWrapper.find('div.alert-body');

              var post_slug = "{{ route('post.show', ':post_slug') }}";
              post_slug = post_slug.replace(':post_slug', data.post.slug);

              var existingNotifications = notifications.html();
var newNotificationHtml = '<a class="dropdown-item d-flex align-items-center" href='+post_slug+'>\
          <div class="ml-3">\
              <div">\
                  <img style="float:right; width:40px; height:40px; object-fit:cover" src='+data.user_image+' width="50px" class="rounded-full"/>\
              </div>\
          </div>\
          <div>\
              <div class="small text-gray-500">'+data.date+'</div>\
              <span>'+data.user_name+' وضع تعليقًا على المنشور <b>'+data.post_title+'<b></span>\
          </div>\
      </a>';
              notifications.html(newNotificationHtml + existingNotifications);
              notificationsCount += 1;  
              notificationsWrapper.find('.notif-count').text(notificationsCount);
              notificationsWrapper.show();
          });
      @endif
    </script>

    <script>
      const setNotificationsCountTo0 = () => {
        const notificationsCount = document.querySelector('#notifications-count');
        notificationsCount.setAttribute('data-count', 0);
        notificationsCount.textContent = 0;
      }
      const getNotifications = () => {
        const notificationsContainer = document.querySelector('#notifications-container');
        $.ajax({
          url: '/notifications',
          type: 'POST',
          data: JSON.stringify({
            "user_id": {{auth()->id()}},
          }),
          contentType: 'application/json',
          processData: false,
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          success: function(response) {
              setNotificationsCountTo0()
              const parsedResponse = JSON.parse(response);
              let notification;
              let result = '';
              parsedResponse.notifications.forEach(response => {
                
                let post_link = "{{ route('post.show', ':post_slug') }}";
                post_link = post_link.replace(':post_slug', response.post_slug);

                notification = `
                <a class="dropdown-item d-flex align-items-center" href="${post_link}">
                  <div class="ml-3">
                    <div>
                      <img style="float:right; width:40px; height:40px; object-fit:cover" src="${response.user_image}" width="50px" class="rounded-full">
                    </div>
                  </div>
                  <div>
                    <div class="small text-gray-500">${response.created_at}</div>
                      <span>
                        ${response.user_name} وضع تعليقًا على المنشور <b>${response.post_title}
                        <b></b></b>
                      </span>
                      <b><b></b></b>
                    </div>
                    <b><b></b></b>
                </a>
                `;
                result += notification;
              });

              notificationsContainer.innerHTML = result;

          },
          error: function(xhr) {

              if (xhr.status === 422) { // 422 Unprocessable Entity (validation error)
                  const errors = xhr.responseJSON.errors;
                  const errorDiv = $('#error-messages');
                  errorDiv.empty(); // Clear previous errors
                  $.each(errors, function(key, messages) {
                      $.each(messages, function(index, message) {
                          errorDiv.append('<p>' + message + '</p>');
                      });
                  });
              } else {
                  console.error('Error:', xhr.responseText);
              }
          }
        });
      }

      const alertBell = document.querySelector('#alertsDropdown');
      alertBell.addEventListener('click', getNotifications);
    </script>

    <script src="{!! asset('theme/js/sb-admin-2.min.js') !!}"></script>
    @yield('script')

  </body>
</html>