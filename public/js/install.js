// This URL must be a full url.
function install()
{
      var manifestUrl = 'https://loadwave.herokuapp.com/manifest.webapp.php';
      var req = navigator.mozApps.install(manifestUrl);
      req.onsuccess = function() {
        alert(this.result.origin);
      };
      req.onerror = function() {
        alert(this.error.name);
      };
}
