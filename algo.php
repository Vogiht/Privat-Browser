<script> 
/**
 * Lightweight script to detect whether the browser is running in Private mode.
 * @returns {Promise<boolean>}
 *
 * This snippet uses Promises. If you want to run it in old browsers, polyfill it:
 * @see https://cdn.jsdelivr.net/npm/es6-promise@4/dist/es6-promise.auto.min.js
 *
 * More Promise Polyfills:
 * @see https://ourcodeworld.com/articles/read/316/top-5-best-javascript-promises-polyfills
 *
 * Source:
 * @see https://gist.github.com/jherax/a81c8c132d09cc354a0e2cb911841ff1
 */
async function isPrivateMode() {
  return new Promise(function detect(resolve) {
    var yes = function() { resolve(true); }; // is in private mode
    var not = function() { resolve(false); }; // not in private mode

    function detectChromeOpera() {
      // https://developers.google.com/web/updates/2017/08/estimating-available-storage-space
      var isChromeOpera = /(?=.*(opera|chrome)).*/i.test(navigator.userAgent) && navigator.storage && navigator.storage.estimate;
      if (isChromeOpera) {
        navigator.storage.estimate().then(function(data) {
          return data.quota < 999999999 ? yes() : not();
        });
      }
      return !!isChromeOpera;
    }

    function detectFirefox() {
      var isMozillaFirefox = 'MozAppearance' in document.documentElement.style;
      if (isMozillaFirefox) {
        if (indexedDB == null) yes();
        else {
          var db = indexedDB.open('inPrivate');
          db.onsuccess = not;
          db.onerror = yes;
        }
      }
      return isMozillaFirefox;
    }

    function detectSafari() {
      var isSafari = navigator.userAgent.match(/Version\/([0-9\._]+).*Safari/);
      if (isSafari) {
        var testLocalStorage = function() {
          try {
            if (localStorage.length) not();
            else {
              localStorage.setItem('inPrivate', '0');
              localStorage.removeItem('inPrivate');
              not();
            }
          } catch (_) {
            // Safari only enables cookie in private mode
            // if cookie is disabled, then all client side storage is disabled
            // if all client side storage is disabled, then there is no point
            // in using private mode
            navigator.cookieEnabled ? yes() : not();
          }
          return true;
        };

        var version = parseInt(isSafari[1], 10);
        if (version < 11) return testLocalStorage();
        try {
          window.openDatabase(null, null, null, null);
          not();
        } catch (_) {
          yes();
        }
      }
      return !!isSafari;
    }

    function detectEdgeIE10() {
      var isEdgeIE10 = !window.indexedDB && (window.PointerEvent || window.MSPointerEvent);
      if (isEdgeIE10) yes();
      return !!isEdgeIE10;
    }

    // when a browser is detected, it runs tests for that browser
    // and skips pointless testing for other browsers.
    if (detectChromeOpera()) return;
    if (detectFirefox()) return;
    if (detectSafari()) return;
    if (detectEdgeIE10()) return;
    
    // default navigation mode
    return not();
  });
}
var flag;
isPrivateMode().then(function(e) {
    flag = e;
   if(flag){document.getElementById("result").innerHTML = "<div class='box'><div class='msg'><p class='caution'>!</p><p>This Site is not accessable in Incognito Modus</p></div></div>";}
  });
</script>
<style>

#result{
  position: relative;
  font-size: 20px;
}

.box{
			background-color: #000000e1;
			color: white;
			padding: 20px;
			text-align: center;
			display: flex;
			justify-content: center;
			padding: 20px;
			min-height: 100vh;
      min-width: 100vw;
			align-items: center;
      position: fixed;
      top: 0;
      left: 0;
      z-index: 999999 !important;
      pointer-events: all;
		}

    .msg{
			background-color: red;
			color: white;
			padding: 50px;
			text-align: center;
      width: 450px;
			display: flex;
			flex-direction: column;
			justify-content: space-around;
			padding: 20px;
			height: 200px;
			align-items: center;
			border-radius: 5px;
			box-shadow: 0px 0px 5px white;
		}

    .msg p{
			font-size: 30px
		}

    .caution{
      font-size: 60px;
      color: red;
      font-weight: 900;
      line-height: 60px;
      width: 60px;
      background: #fff;
      border-radius: 50%;
    }
    </style>

   <div id="result"></div>
