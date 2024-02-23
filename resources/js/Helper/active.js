export default {
    active(url) { 
        let pathname = window.location.pathname
        if (pathname == '/') {
          pathname  = '';
        }
        return window.location.origin + pathname == route('home' + url) ? 'text-blue-400' : 'text-gray-700';
      }
}