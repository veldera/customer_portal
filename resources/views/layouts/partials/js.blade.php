<script>
close=document.getElementById("close");close.addEventListener('click',function(){close.style.opacity="0"; setTimeout(function(){ close.style.display="none"; }, 600); },false);
   var _portal = {
       currencySymbol: '{{Config::get("customer_portal.currency_symbol")}}',
       thousandsSeparator: '{{Config::get("customer_portal.thousands_separator")}}',
       decimalSeparator: '{{Config::get("customer_portal.decimal_separator")}}'
   };
</script>


<!-- intercom embed -->
<script>
var INTERCOM_ENABLED = false

document.addEventListener("DOMContentLoaded", function() {
    // launch intercom
    try {
      buildIntercom()
    } catch(e) {
      return;
      // it'll catch when user isn't logged in
      console.log(e)
    }
});

function buildIntercom() {
fetch('/portal/profile/json')
  .then((response) => {
    if (response.redirected) {
      return false
    } else {
      return response.json()
    }
  })
  .then((json) => {
    if (json == false) {
      window.intercomSettings = null
      return
    } else {
      var d = new Date(Date.now)
      var i = {
          // vendor api public token
            app_id: '{{Config::get("customer_portal.intercom_app_id")}}',
          // to be filled out programatically
            name: '',
            email: '',
            user_id: '',
            created_at: d
        }
        i.email = json[0].email_address
        i.name = json[0].contact_name
        i.user_id = json[0].account_id
        window.intercomSettings = i;
    }
  })
}
</script>
<script>
setTimeout(() => {
            if (window.intercomSettings) {
                (function() {
                    var w = window;
                    var ic = w.Intercom;
                    if (typeof ic === "function") {
                        ic('reattach_activator');
                        ic('update', w.intercomSettings);
                    } else {
                        var d = document;
                        var i = function() {
                            i.c(arguments);
                        };
                        i.q = [];
                        i.c = function(args) {
                            i.q.push(args);
                        };
                        w.Intercom = i;
                        var l = function() {
                            var s = d.createElement('script');
                            s.type = 'text/javascript';
                            s.async = true;
                            s.src = 'https://widget.intercom.io/widget/{{Config::get("customer_portal.intercom_app_id")}}';
                            var x = d.getElementsByTagName('script')[0];
                            x.parentNode.insertBefore(s, x);
                        };
                        if (w.attachEvent) {
                            w.attachEvent('onload', l);
                        } else {
                            w.addEventListener('load', l, false);
                        }
                    }
			})();
	}
}, 400);
</script>
<!-- end intercom embed -->


<script src="/assets/libs/jquery/dist/jquery.min.js"></script>
<script src="/assets/lang.dist.js"></script>
<script src="/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script src="/assets/libs/chart.js/dist/Chart.min.js"></script>
<script src="/assets/libs/chart.js/Chart.extension.min.js"></script>
<script src="/assets/libs/highlight/highlight.pack.min.js"></script>
<script src="/assets/libs/flatpickr/dist/flatpickr.min.js"></script>
<script src="/assets/libs/list.js/dist/list.min.js"></script>
<script src="/assets/libs/select2/select2.min.js"></script>
<script src="/assets/libs/jquery-mask-plugin/dist/jquery.mask.min.js"></script>
<script src="/assets/libs/jquery-payment-plugin/jquery.payment.min.js"></script>
<script src="/assets/libs/moment/moment.min.js"></script>
<script src="/assets/libs/instantclick/instantclick.js"></script>
<script>
   moment.locale('{{Config::get("app.locale")}}');
   $(document).ready(function(){
   $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});$(".languageSelector").change(function(){var language = $(this).val();$.ajax("/language",{data: {language: language},dataType: 'json',type: 'POST'}).then(function() {setTimeout(function(){location.reload();}, 100);});});});
   Number.prototype.formatCurrency = function(c){
       var n = this,
           c = isNaN(c = Math.abs(c)) ? 2 : c,
           d = _portal.decimalSeparator,
           t = _portal.thousandsSeparator,
           s = n < 0 ? "-" : "",
           i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "",
           j = (j = i.length) > 3 ? j % 3 : 0;
       return _portal.currencySymbol + s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
   };
</script>
@yield('additionalJS')
