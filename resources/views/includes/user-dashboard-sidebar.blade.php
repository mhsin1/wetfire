@php 

if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') 
{
  $link = "https"; 
}
else
{
  $link = "http"; 
    
  // Here append the common URL characters. 
  $link .= "://"; 
    
  // Append the host(domain name, ip) to the URL. 
  $link .= $_SERVER['HTTP_HOST']; 
    
  // Append the requested resource location to the URL 
  $link .= $_SERVER['REQUEST_URI']; 
}      

@endphp

<div class="column-block">
      <div class="columnblock-title">Account</div>
      <div class="account-block">
          <div class="list-group"> 
          <a class="list-group-item {{ $link == route('user-dashboard') ? 'active':'' }}" href="{{ route('user-dashboard') }}">
            {{ $langg->lang200 }}
          </a>
          <a  class="list-group-item {{ $link == route('user-orders') ? 'active':'' }}" href="{{ route('user-orders') }}">
            {{ $langg->lang201 }}
          </a>
          <a class="list-group-item {{ $link == route('user-profile') ? 'active':'' }}" href="{{ route('user-profile') }}">
            {{ $langg->lang205 }}
          </a>

            <a href="{{ route('user-reset') }}" class="list-group-item {{ $link == route('user-reset') ? 'active':'' }}">
              {{ $langg->lang206 }}
            </a>

            <a href="{{ route('user-wishlists') }}" class="list-group-item {{ $link == route('user-wishlists') ? 'active':'' }}">
              Wishlists
            </a>

            <a class="nav-list-group-item" href="{{ route('user-logout') }}">
              {{ $langg->lang207 }}
            </a>
      </div>
  </div>
  </div>