(function ($) {
    $.pagePreLoading = function (url, loaded) {
        var loader = $('<iframe style="display:none"></iframe>');
        var loadingwrap = $('<div class="pagepreloadingbox" style="width:220px;"><p>正在跳转...</p><br /><div style="width:200px;text-align:center;margin:20px auto;" class="perLoading"><span style="font-size:80px;float: none;margin-left: none;" class="loadingspan">0</span>%</div><div style="height:3px;background:#1ABC9C;width:0%;margin-top:10px;" class="loadingProcess"></div></div>');
        $(document.body).append(loader);
        $(document.body).append(loadingwrap);
        var loadingSpan = loadingwrap.find(".loadingspan");
        var loadingProcess = loadingwrap.find(".loadingProcess");

        var timeOut = 100;
        var percent = 0;

        loader.load(function () {
            timeOut = 10;
        });

        var process = function () {
            loadingSpan.html(percent);
            loadingProcess.css({ width: percent + '%' });
            if (timeOut >= 100) {
                timeOut += 100;
            }
            percent++;
            if (percent < 100)
                setTimeout(function () { process() }, timeOut);
            else
            {
                if (typeof loaded == 'function')
                    loaded();
                //$.fancybox.close();
            }
        };
        loader.attr("src", url);
        $.fancybox.open(loadingwrap, {
            'closeBtn': false,
            helpers: {
                overlay: null
            }
        })
        process();
    }
})(jQuery);

