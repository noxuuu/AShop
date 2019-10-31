(window.webpackJsonp = window.webpackJsonp || []).push([
    ["dore"], {
        "+UE2": function(e, t, a) {
            var o = a("EVdn");
            o.fn.addCommas = function(e) {
                for (var t = (e += "").split("."), a = t[0], o = t.length > 1 ? "." + t[1] : "", n = /(\d+)(\d{3})/; n.test(a);) a = a.replace(n, "$1,$2");
                return a + o
            }, o.shiftSelectable = function(e, t) {
                var a = this;
                t = o.extend({
                    items: ".card"
                }, t);
                var n, i = o(e),
                    r = null,
                    s = i.find("input[type='checkbox']");

                function l(e, t) {
                    if (o(e).prop("checked", !o(e).prop("checked")).trigger("change"), n || (n = e), n) {
                        if (t) {
                            var a = s.index(e),
                                i = s.index(n);
                            s.slice(Math.min(a, i), Math.max(a, i) + 1).prop("checked", n.checked).trigger("change")
                        }
                        n = e
                    }
                    if (r) {
                        var l = !1,
                            c = !0;
                        s.each(function() {
                            o(this).prop("checked") ? l = !0 : c = !1
                        }), l ? r.prop("indeterminate", l) : (r.prop("indeterminate", l), r.prop("checked", l)), c && (r.prop("indeterminate", !1), r.prop("checked", c))
                    }
                    document.activeElement.blur(), d()
                }

                function d() {
                    s.each(function() {
                        o(this).prop("checked") ? o(this).parents(".card").addClass("active") : o(this).parents(".card").removeClass("active")
                    })
                }
                i.data("checkAll") && (r = o("#" + i.data("checkAll"))).on("click", function() {
                    s.prop("checked", o(r).prop("checked")).trigger("change"), document.activeElement.blur(), d()
                }), i.on("click", t.items, function(e) {
                    o(e.target).is("a") || o(e.target).parent().is("a") || (o(e.target).is("input[type='checkbox']") && (e.preventDefault(), e.stopPropagation()), l(o(this).find("input[type='checkbox']")[0], e.shiftKey))
                }), a.selectAll = function() {
                    r && (s.prop("checked", !0).trigger("change"), r.prop("checked", !0), r.prop("indeterminate", !1), d())
                }, a.deSelectAll = function() {
                    r && (s.prop("checked", !1).trigger("change"), r.prop("checked", !1), r.prop("indeterminate", !1), d())
                }, a.rightClick = function(e) {
                    var t = o(e).find("input[type='checkbox']")[0];
                    o(t).prop("checked") || (a.deSelectAll(), l(t, !1))
                }
            }, o.fn.shiftSelectable = function(e) {
                return this.each(function() {
                    if (null == o(this).data("shiftSelectable")) {
                        var t = new o.shiftSelectable(this, e);
                        o(this).data("shiftSelectable", t)
                    }
                })
            }, o.dore = function(e, t) {
                var a = {},
                    n = this;
                n.settings = {};
                o(e), e = e;
                ! function() {
                    he = he || {}, n.settings = o.extend({}, a, he);
                    var e = getComputedStyle(document.body),
                        t = e.getPropertyValue("--theme-color-1").trim(),
                        i = e.getPropertyValue("--theme-color-2").trim(),
                        r = e.getPropertyValue("--theme-color-3").trim(),
                        s = e.getPropertyValue("--theme-color-4").trim(),
                        l = e.getPropertyValue("--theme-color-5").trim(),
                        d = (e.getPropertyValue("--theme-color-6").trim(), e.getPropertyValue("--theme-color-1-10").trim()),
                        c = e.getPropertyValue("--theme-color-2-10").trim(),
                        u = e.getPropertyValue("--theme-color-3-10").trim(),
                        p = e.getPropertyValue("--theme-color-4-10").trim(),
                        h = e.getPropertyValue("--theme-color-5-10").trim(),
                        m = (e.getPropertyValue("--theme-color-6-10").trim(), e.getPropertyValue("--primary-color").trim()),
                        g = e.getPropertyValue("--foreground-color").trim(),
                        b = e.getPropertyValue("--separator-color").trim(),
                        f = 1440,
                        C = 768,
                        y = 768;

                    function w() {
                        var e = o(window).outerHeight(),
                            t = o(window).outerWidth(),
                            a = o(".navbar").outerHeight(),
                            n = parseInt(o(".sub-menu .scroll").css("margin-top"), 10);
                        o(".sub-menu .scroll").css("height", e - a - 2 * n), o(".main-menu .scroll").css("height", e - a), o(".app-menu .scroll").css("height", e - a - 40), o(".chat-app .scroll").length > 0 && de && (o(".chat-app .scroll").scrollTop(o(".chat-app .scroll").prop("scrollHeight")), de.update()), t < y ? o("#app-container").addClass("menu-mobile") : t < f ? (o("#app-container").removeClass("menu-mobile"), o("#app-container").hasClass("menu-default") && (o("#app-container").removeClass(S), o("#app-container").addClass("menu-default menu-sub-hidden"))) : (o("#app-container").removeClass("menu-mobile"), o("#app-container").hasClass("menu-default") && o("#app-container").hasClass("menu-sub-hidden") && o("#app-container").removeClass("menu-sub-hidden")), B(0, !0)
                    }

                    function v() {
                        var e = o(".search input").val(),
                            t = o(".search").data("searchPath");
                        "" != e && (o(".search input").val(""), window.location.href = t + e)
                    }

                    function x() {
                        o(".search").hasClass("mobile-view") && (o(".search").removeClass("mobile-view"), o(".search input").val(""))
                    }
                    o(window).on("resize", function(e) {
                        e.originalEvent.isTrusted && w()
                    }), w(), o(".search .search-icon").on("click", function() {
                        o(window).outerWidth() < C ? o(".search").hasClass("mobile-view") ? (o(".search").removeClass("mobile-view"), v()) : (o(".search").addClass("mobile-view"), o(".search input").focus()) : v()
                    }), o(".search input").on("keyup", function(e) {
                        13 == e.which && v(), 27 == e.which && x()
                    }), o(document).on("click", function(e) {
                        o(e.target).parents().hasClass("search") || x()
                    }), o(".list").shiftSelectable();
                    var k = 0,
                        S = "menu-default menu-hidden sub-hidden main-hidden menu-sub-hidden main-show-temporary sub-show-temporary menu-mobile";

                    function B(e, t, a) {
                        k = e;
                        var n = o("#app-container");
                        if (0 != n.length) {
                            if (a = a || W(), 0 == o(".sub-menu ul[data-link='" + a + "']").length && (2 == k || t) && o(window).outerWidth() >= y && A("menu-default")) return t ? (o("#app-container").removeClass(S), o("#app-container").addClass("menu-default menu-sub-hidden sub-hidden"), k = 1) : (o("#app-container").removeClass(S), o("#app-container").addClass("menu-default main-hidden menu-sub-hidden sub-hidden"), k = 0), void P();
                            if (0 == o(".sub-menu ul[data-link='" + a + "']").length && (1 == k || t) && o(window).outerWidth() >= y && A("menu-sub-hidden")) return t ? (o("#app-container").removeClass(S), o("#app-container").addClass("menu-sub-hidden sub-hidden"), k = 0) : (o("#app-container").removeClass(S), o("#app-container").addClass("menu-sub-hidden main-hidden sub-hidden"), k = -1), void P();
                            if (0 == o(".sub-menu ul[data-link='" + a + "']").length && (1 == k || t) && o(window).outerWidth() >= y && A("menu-hidden")) return t ? (o("#app-container").removeClass(S), o("#app-container").addClass("menu-hidden main-hidden sub-hidden"), k = 0) : (o("#app-container").removeClass(S), o("#app-container").addClass("menu-hidden main-show-temporary"), k = 3), void P();
                            e % 4 == 0 ? (A("menu-default") && A("menu-sub-hidden") ? nextClasses = "menu-default menu-sub-hidden" : A("menu-default") ? nextClasses = "menu-default" : A("menu-sub-hidden") ? nextClasses = "menu-sub-hidden" : A("menu-hidden") && (nextClasses = "menu-hidden"), k = 0) : e % 4 == 1 ? A("menu-default") && A("menu-sub-hidden") ? nextClasses = "menu-default menu-sub-hidden main-hidden sub-hidden" : A("menu-default") ? nextClasses = "menu-default sub-hidden" : A("menu-sub-hidden") ? nextClasses = "menu-sub-hidden main-hidden sub-hidden" : A("menu-hidden") && (nextClasses = "menu-hidden main-show-temporary") : e % 4 == 2 ? A("menu-default") && A("menu-sub-hidden") ? nextClasses = "menu-default menu-sub-hidden sub-hidden" : A("menu-default") ? nextClasses = "menu-default main-hidden sub-hidden" : A("menu-sub-hidden") ? nextClasses = "menu-sub-hidden sub-hidden" : A("menu-hidden") && (nextClasses = "menu-hidden main-show-temporary sub-show-temporary") : e % 4 == 3 && (A("menu-default") && A("menu-sub-hidden") ? nextClasses = "menu-default menu-sub-hidden sub-show-temporary" : A("menu-default") ? nextClasses = "menu-default sub-hidden" : A("menu-sub-hidden") ? nextClasses = "menu-sub-hidden sub-show-temporary" : A("menu-hidden") && (nextClasses = "menu-hidden main-show-temporary")), A("menu-mobile") && (nextClasses += " menu-mobile"), n.removeClass(S), n.addClass(nextClasses), P()
                        }
                    }

                    function W() {
                        return o(".main-menu ul li.active a").attr("href").replace("#", "")
                    }

                    function A(e) {
                        return o("#app-container").attr("class").split(" ").filter(function(e) {
                            return "" != e
                        }).includes(e)
                    }
                    o(".menu-button").on("click", function(e) {
                        e.preventDefault(), B(++k)
                    }), o(".menu-button-mobile").on("click", function(e) {
                        return e.preventDefault(), o("#app-container").removeClass("sub-show-temporary").toggleClass("main-show-temporary"), !1
                    }), o(".main-menu").on("click", "a", function(e) {
                        e.preventDefault();
                        var t = o(this).attr("href").replace("#", "");
                        if (0 != o(".sub-menu ul[data-link='" + t + "']").length) return I(o(this).attr("href")), o("#app-container"), o("#app-container").hasClass("menu-mobile") ? o("#app-container").addClass("sub-show-temporary") : !o("#app-container").hasClass("menu-sub-hidden") || 2 != k && 0 != k ? !o("#app-container").hasClass("menu-hidden") || 1 != k && 3 != k ? !o("#app-container").hasClass("menu-default") || o("#app-container").hasClass("menu-sub-hidden") || 1 != k && 3 != k || B(0, !1, t) : B(2, !1, t) : B(3, !1, t), !1;
                        window.location.href = t
                    }), o(document).on("click", function(e) {
                        o(e.target).parents().hasClass("menu-button") || o(e.target).hasClass("menu-button") || o(e.target).parents().hasClass("sidebar") || o(e.target).hasClass("sidebar") || (o("#app-container").hasClass("menu-sub-hidden") && 3 == k ? B(W() == E ? 2 : 0) : (o("#app-container").hasClass("menu-hidden") || o("#app-container").hasClass("menu-mobile")) && B(0))
                    });
                    var E = "";

                    function I(e) {
                        if (0 != o(".main-menu").length) {
                            var t = e.replace("#", "");
                            if (0 == o(".sub-menu ul[data-link='" + t + "']").length) {
                                if (o("#app-container").removeClass("sub-show-temporary"), 0 == o("#app-container").length) return;
                                return k = A("menu-sub-hidden") || A("menu-hidden") ? 0 : 1, o("#app-container").addClass("sub-hidden"), o(".sub-menu").addClass("no-transition"), o("main").addClass("no-transition"), void setTimeout(function() {
                                    o(".sub-menu").removeClass("no-transition"), o("main").removeClass("no-transition")
                                }, 350)
                            }
                            t != E && (o(".sub-menu ul").fadeOut(0), o(".sub-menu ul[data-link='" + t + "']").slideDown(100), o(".sub-menu .scroll").scrollTop(0), E = t)
                        }
                    }

                    function P() {
                        setTimeout(function() {
                            var e = document.createEvent("HTMLEvents");
                            e.initEvent("resize", !1, !1), window.dispatchEvent(e)
                        }, 350)
                    }

                    function R(e) {
                        var t = o(e.parents(".question"));
                        t.toggleClass("edit-quesiton"), t.toggleClass("view-quesiton");
                        var a = t.find(".question-collapse");
                        a.hasClass("show") || (a.collapse("toggle"), t.find(".rotate-icon-click").toggleClass("rotate"))
                    }
                    if (I(o(".main-menu ul li.active a").attr("href")), o(".app-menu-button").on("click", function() {
                        event.preventDefault(), o(".app-menu").hasClass("shown") ? o(".app-menu").removeClass("shown") : o(".app-menu").addClass("shown")
                    }), o(document).on("click", function(e) {
                        o(e.target).parents().hasClass("app-menu") || o(e.target).parents().hasClass("app-menu-button") || o(e.target).hasClass("app-menu-button") || o(e.target).hasClass("app-menu") || o(".app-menu").hasClass("shown") && o(".app-menu").removeClass("shown")
                    }), o(document).on("click", ".question .view-button", function() {
                        R(o(this))
                    }), o(document).on("click", ".question .edit-button", function() {
                        R(o(this))
                    }), o(document).on("click", ".rotate-icon-click", function() {
                        o(this).toggleClass("rotate")
                    }), "undefined" != typeof Chart) {
                        Chart.defaults.global.defaultFontFamily = "'Nunito', sans-serif", Chart.defaults.LineWithShadow = Chart.defaults.line, Chart.controllers.LineWithShadow = Chart.controllers.line.extend({
                            draw: function(e) {
                                Chart.controllers.line.prototype.draw.call(this, e);
                                var t = this.chart.ctx;
                                t.save(), t.shadowColor = "rgba(0,0,0,0.15)", t.shadowBlur = 10, t.shadowOffsetX = 0, t.shadowOffsetY = 10, t.responsive = !0, t.stroke(), Chart.controllers.line.prototype.draw.apply(this, arguments), t.restore()
                            }
                        }), Chart.defaults.BarWithShadow = Chart.defaults.bar, Chart.controllers.BarWithShadow = Chart.controllers.bar.extend({
                            draw: function(e) {
                                Chart.controllers.bar.prototype.draw.call(this, e);
                                var t = this.chart.ctx;
                                t.save(), t.shadowColor = "rgba(0,0,0,0.15)", t.shadowBlur = 12, t.shadowOffsetX = 5, t.shadowOffsetY = 10, t.responsive = !0, Chart.controllers.bar.prototype.draw.apply(this, arguments), t.restore()
                            }
                        }), Chart.defaults.LineWithLine = Chart.defaults.line, Chart.controllers.LineWithLine = Chart.controllers.line.extend({
                            draw: function(e) {
                                if (Chart.controllers.line.prototype.draw.call(this, e), this.chart.tooltip._active && this.chart.tooltip._active.length) {
                                    var t = this.chart.tooltip._active[0],
                                        a = this.chart.ctx,
                                        o = t.tooltipPosition().x,
                                        n = this.chart.scales["y-axis-0"].top,
                                        i = this.chart.scales["y-axis-0"].bottom;
                                    a.save(), a.beginPath(), a.moveTo(o, n), a.lineTo(o, i), a.lineWidth = 1, a.strokeStyle = "rgba(0,0,0,0.1)", a.stroke(), a.restore()
                                }
                            }
                        }), Chart.defaults.DoughnutWithShadow = Chart.defaults.doughnut, Chart.controllers.DoughnutWithShadow = Chart.controllers.doughnut.extend({
                            draw: function(e) {
                                Chart.controllers.doughnut.prototype.draw.call(this, e);
                                var t = this.chart.chart.ctx;
                                t.save(), t.shadowColor = "rgba(0,0,0,0.15)", t.shadowBlur = 10, t.shadowOffsetX = 0, t.shadowOffsetY = 10, t.responsive = !0, Chart.controllers.doughnut.prototype.draw.apply(this, arguments), t.restore()
                            }
                        }), Chart.defaults.PieWithShadow = Chart.defaults.pie, Chart.controllers.PieWithShadow = Chart.controllers.pie.extend({
                            draw: function(e) {
                                Chart.controllers.pie.prototype.draw.call(this, e);
                                var t = this.chart.chart.ctx;
                                t.save(), t.shadowColor = "rgba(0,0,0,0.15)", t.shadowBlur = 10, t.shadowOffsetX = 0, t.shadowOffsetY = 10, t.responsive = !0, Chart.controllers.pie.prototype.draw.apply(this, arguments), t.restore()
                            }
                        }), Chart.defaults.ScatterWithShadow = Chart.defaults.scatter, Chart.controllers.ScatterWithShadow = Chart.controllers.scatter.extend({
                            draw: function(e) {
                                Chart.controllers.scatter.prototype.draw.call(this, e);
                                var t = this.chart.chart.ctx;
                                t.save(), t.shadowColor = "rgba(0,0,0,0.2)", t.shadowBlur = 7, t.shadowOffsetX = 0, t.shadowOffsetY = 7, t.responsive = !0, Chart.controllers.scatter.prototype.draw.apply(this, arguments), t.restore()
                            }
                        }), Chart.defaults.RadarWithShadow = Chart.defaults.radar, Chart.controllers.RadarWithShadow = Chart.controllers.radar.extend({
                            draw: function(e) {
                                Chart.controllers.radar.prototype.draw.call(this, e);
                                var t = this.chart.chart.ctx;
                                t.save(), t.shadowColor = "rgba(0,0,0,0.2)", t.shadowBlur = 7, t.shadowOffsetX = 0, t.shadowOffsetY = 7, t.responsive = !0, Chart.controllers.radar.prototype.draw.apply(this, arguments), t.restore()
                            }
                        }), Chart.defaults.PolarWithShadow = Chart.defaults.polarArea, Chart.controllers.PolarWithShadow = Chart.controllers.polarArea.extend({
                            draw: function(e) {
                                Chart.controllers.polarArea.prototype.draw.call(this, e);
                                var t = this.chart.chart.ctx;
                                t.save(), t.shadowColor = "rgba(0,0,0,0.2)", t.shadowBlur = 10, t.shadowOffsetX = 5, t.shadowOffsetY = 10, t.responsive = !0, Chart.controllers.polarArea.prototype.draw.apply(this, arguments), t.restore()
                            }
                        });
                        var T = {
                            backgroundColor: g,
                            titleFontColor: m,
                            borderColor: b,
                            borderWidth: .5,
                            bodyFontColor: m,
                            bodySpacing: 10,
                            xPadding: 15,
                            yPadding: 15,
                            cornerRadius: .15,
                            displayColors: !1
                        };
                        if (document.getElementById("visitChartFull")) {
                            var z = document.getElementById("visitChartFull").getContext("2d");
                            new Chart(z, {
                                type: "LineWithShadow",
                                data: {
                                    labels: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
                                    datasets: [{
                                        label: "Data",
                                        borderColor: t,
                                        pointBorderColor: t,
                                        pointBackgroundColor: t,
                                        pointHoverBackgroundColor: t,
                                        pointHoverBorderColor: t,
                                        pointRadius: 3,
                                        pointBorderWidth: 3,
                                        pointHoverRadius: 3,
                                        fill: !0,
                                        backgroundColor: d,
                                        borderWidth: 2,
                                        data: [180, 140, 150, 120, 180, 110, 160],
                                        datalabels: {
                                            align: "end",
                                            anchor: "end"
                                        }
                                    }]
                                },
                                options: {
                                    layout: {
                                        padding: {
                                            left: 0,
                                            right: 0,
                                            top: 40,
                                            bottom: 0
                                        }
                                    },
                                    plugins: {
                                        datalabels: {
                                            backgroundColor: "transparent",
                                            borderRadius: 30,
                                            borderWidth: 1,
                                            padding: 5,
                                            borderColor: function(e) {
                                                return e.dataset.borderColor
                                            },
                                            color: function(e) {
                                                return e.dataset.borderColor
                                            },
                                            font: {
                                                weight: "bold",
                                                size: 10
                                            },
                                            formatter: Math.round
                                        }
                                    },
                                    responsive: !0,
                                    maintainAspectRatio: !1,
                                    legend: {
                                        display: !1
                                    },
                                    tooltips: T,
                                    scales: {
                                        yAxes: [{
                                            ticks: {
                                                min: 0
                                            },
                                            display: !1
                                        }],
                                        xAxes: [{
                                            ticks: {
                                                min: 0
                                            },
                                            display: !1
                                        }]
                                    }
                                }
                            })
                        }
                        if (document.getElementById("visitChart")) {
                            var L = document.getElementById("visitChart").getContext("2d");
                            new Chart(L, {
                                type: "LineWithShadow",
                                options: {
                                    plugins: {
                                        datalabels: {
                                            display: !1
                                        }
                                    },
                                    responsive: !0,
                                    maintainAspectRatio: !1,
                                    scales: {
                                        yAxes: [{
                                            gridLines: {
                                                display: !0,
                                                lineWidth: 1,
                                                color: "rgba(0,0,0,0.1)",
                                                drawBorder: !1
                                            },
                                            ticks: {
                                                beginAtZero: !0,
                                                stepSize: 5,
                                                min: 50,
                                                max: 70,
                                                padding: 0
                                            }
                                        }],
                                        xAxes: [{
                                            gridLines: {
                                                display: !1
                                            }
                                        }]
                                    },
                                    legend: {
                                        display: !1
                                    },
                                    tooltips: T
                                },
                                data: {
                                    labels: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
                                    datasets: [{
                                        label: "",
                                        data: [54, 63, 60, 65, 60, 68, 60],
                                        borderColor: t,
                                        pointBackgroundColor: g,
                                        pointBorderColor: t,
                                        pointHoverBackgroundColor: t,
                                        pointHoverBorderColor: g,
                                        pointRadius: 4,
                                        pointBorderWidth: 2,
                                        pointHoverRadius: 5,
                                        fill: !0,
                                        borderWidth: 2,
                                        backgroundColor: d
                                    }]
                                }
                            })
                        }
                        if (document.getElementById("conversionChart")) {
                            var D = document.getElementById("conversionChart").getContext("2d");
                            new Chart(D, {
                                type: "LineWithShadow",
                                options: {
                                    plugins: {
                                        datalabels: {
                                            display: !1
                                        }
                                    },
                                    responsive: !0,
                                    maintainAspectRatio: !1,
                                    scales: {
                                        yAxes: [{
                                            gridLines: {
                                                display: !0,
                                                lineWidth: 1,
                                                color: "rgba(0,0,0,0.1)",
                                                drawBorder: !1
                                            },
                                            ticks: {
                                                beginAtZero: !0,
                                                stepSize: 5,
                                                min: 50,
                                                max: 70,
                                                padding: 0
                                            }
                                        }],
                                        xAxes: [{
                                            gridLines: {
                                                display: !1
                                            }
                                        }]
                                    },
                                    legend: {
                                        display: !1
                                    },
                                    tooltips: T
                                },
                                data: {
                                    labels: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
                                    datasets: [{
                                        label: "",
                                        data: [65, 60, 68, 54, 63, 60, 60],
                                        borderColor: i,
                                        pointBackgroundColor: g,
                                        pointBorderColor: i,
                                        pointHoverBackgroundColor: i,
                                        pointHoverBorderColor: g,
                                        pointRadius: 4,
                                        pointBorderWidth: 2,
                                        pointHoverRadius: 5,
                                        fill: !0,
                                        borderWidth: 2,
                                        backgroundColor: c
                                    }]
                                }
                            })
                        }
                        var F = {
                                layout: {
                                    padding: {
                                        left: 5,
                                        right: 5,
                                        top: 10,
                                        bottom: 10
                                    }
                                },
                                plugins: {
                                    datalabels: {
                                        display: !1
                                    }
                                },
                                responsive: !0,
                                maintainAspectRatio: !1,
                                legend: {
                                    display: !1
                                },
                                tooltips: {
                                    intersect: !1,
                                    enabled: !1,
                                    custom: function(e) {
                                        if (e && e.dataPoints) {
                                            var t = o(this._chart.canvas.offsetParent),
                                                a = e.dataPoints[0].yLabel,
                                                n = e.dataPoints[0].xLabel,
                                                i = e.body[0].lines[0].split(":")[0];
                                            t.find(".value").html("$" + o.fn.addCommas(a)), t.find(".label").html(i + "-" + n)
                                        }
                                    }
                                },
                                scales: {
                                    yAxes: [{
                                        ticks: {
                                            beginAtZero: !0
                                        },
                                        display: !1
                                    }],
                                    xAxes: [{
                                        display: !1
                                    }]
                                }
                            },
                            H = {
                                afterInit: function(e, t) {
                                    var a = o(e.canvas.offsetParent),
                                        n = e.data.datasets[0].data[0],
                                        i = e.data.labels[0],
                                        r = e.data.datasets[0].label;
                                    a.find(".value").html("$" + o.fn.addCommas(n)), a.find(".label").html(r + "-" + i)
                                }
                            };
                        if (document.getElementById("smallChart1")) {
                            var M = document.getElementById("smallChart1").getContext("2d");
                            new Chart(M, {
                                type: "LineWithLine",
                                plugins: [H],
                                data: {
                                    labels: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
                                    datasets: [{
                                        label: "Total Orders",
                                        borderColor: t,
                                        pointBorderColor: t,
                                        pointHoverBackgroundColor: t,
                                        pointHoverBorderColor: t,
                                        pointRadius: 2,
                                        pointBorderWidth: 3,
                                        pointHoverRadius: 2,
                                        fill: !1,
                                        borderWidth: 2,
                                        data: [1250, 1300, 1550, 921, 1810, 1106, 1610],
                                        datalabels: {
                                            align: "end",
                                            anchor: "end"
                                        }
                                    }]
                                },
                                options: F
                            })
                        }
                        if (document.getElementById("smallChart2") && (M = document.getElementById("smallChart2").getContext("2d"), new Chart(M, {
                            type: "LineWithLine",
                            plugins: [H],
                            data: {
                                labels: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
                                datasets: [{
                                    label: "Pending Orders",
                                    borderColor: t,
                                    pointBorderColor: t,
                                    pointHoverBackgroundColor: t,
                                    pointHoverBorderColor: t,
                                    pointRadius: 2,
                                    pointBorderWidth: 3,
                                    pointHoverRadius: 2,
                                    fill: !1,
                                    borderWidth: 2,
                                    data: [115, 120, 300, 222, 105, 85, 36],
                                    datalabels: {
                                        align: "end",
                                        anchor: "end"
                                    }
                                }]
                            },
                            options: F
                        })), document.getElementById("smallChart3") && (M = document.getElementById("smallChart3").getContext("2d"), new Chart(M, {
                            type: "LineWithLine",
                            plugins: [H],
                            data: {
                                labels: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
                                datasets: [{
                                    label: "Active Orders",
                                    borderColor: t,
                                    pointBorderColor: t,
                                    pointHoverBackgroundColor: t,
                                    pointHoverBorderColor: t,
                                    pointRadius: 2,
                                    pointBorderWidth: 3,
                                    pointHoverRadius: 2,
                                    fill: !1,
                                    borderWidth: 2,
                                    data: [350, 452, 762, 952, 630, 85, 158],
                                    datalabels: {
                                        align: "end",
                                        anchor: "end"
                                    }
                                }]
                            },
                            options: F
                        })), document.getElementById("smallChart4") && (M = document.getElementById("smallChart4").getContext("2d"), new Chart(M, {
                            type: "LineWithLine",
                            plugins: [H],
                            data: {
                                labels: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
                                datasets: [{
                                    label: "Shipped Orders",
                                    borderColor: t,
                                    pointBorderColor: t,
                                    pointHoverBackgroundColor: t,
                                    pointHoverBorderColor: t,
                                    pointRadius: 2,
                                    pointBorderWidth: 3,
                                    pointHoverRadius: 2,
                                    fill: !1,
                                    borderWidth: 2,
                                    data: [200, 452, 250, 630, 125, 85, 20],
                                    datalabels: {
                                        align: "end",
                                        anchor: "end"
                                    }
                                }]
                            },
                            options: F
                        })), document.getElementById("salesChart")) {
                            var N = document.getElementById("salesChart").getContext("2d");
                            new Chart(N, {
                                type: "LineWithShadow",
                                options: {
                                    plugins: {
                                        datalabels: {
                                            display: !1
                                        }
                                    },
                                    responsive: !0,
                                    maintainAspectRatio: !1,
                                    scales: {
                                        yAxes: [{
                                            gridLines: {
                                                display: !0,
                                                lineWidth: 1,
                                                color: "rgba(0,0,0,0.1)",
                                                drawBorder: !1
                                            },
                                            ticks: {
                                                beginAtZero: !0,
                                                stepSize: 5,
                                                min: 50,
                                                max: 70,
                                                padding: 20
                                            }
                                        }],
                                        xAxes: [{
                                            gridLines: {
                                                display: !1
                                            }
                                        }]
                                    },
                                    legend: {
                                        display: !1
                                    },
                                    tooltips: T
                                },
                                data: {
                                    labels: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
                                    datasets: [{
                                        label: "",
                                        data: [54, 63, 60, 65, 60, 68, 60],
                                        borderColor: t,
                                        pointBackgroundColor: g,
                                        pointBorderColor: t,
                                        pointHoverBackgroundColor: t,
                                        pointHoverBorderColor: g,
                                        pointRadius: 6,
                                        pointBorderWidth: 2,
                                        pointHoverRadius: 8,
                                        fill: !1
                                    }]
                                }
                            })
                        }
                        if (document.getElementById("areaChart")) {
                            var O = document.getElementById("areaChart").getContext("2d");
                            new Chart(O, {
                                type: "LineWithShadow",
                                options: {
                                    plugins: {
                                        datalabels: {
                                            display: !1
                                        }
                                    },
                                    responsive: !0,
                                    maintainAspectRatio: !1,
                                    scales: {
                                        yAxes: [{
                                            gridLines: {
                                                display: !0,
                                                lineWidth: 1,
                                                color: "rgba(0,0,0,0.1)",
                                                drawBorder: !1
                                            },
                                            ticks: {
                                                beginAtZero: !0,
                                                stepSize: 5,
                                                min: 50,
                                                max: 70,
                                                padding: 0
                                            }
                                        }],
                                        xAxes: [{
                                            gridLines: {
                                                display: !1
                                            }
                                        }]
                                    },
                                    legend: {
                                        display: !1
                                    },
                                    tooltips: T
                                },
                                data: {
                                    labels: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
                                    datasets: [{
                                        label: "",
                                        data: [54, 63, 60, 65, 60, 68, 60],
                                        borderColor: t,
                                        pointBackgroundColor: g,
                                        pointBorderColor: t,
                                        pointHoverBackgroundColor: t,
                                        pointHoverBorderColor: g,
                                        pointRadius: 4,
                                        pointBorderWidth: 2,
                                        pointHoverRadius: 5,
                                        fill: !0,
                                        borderWidth: 2,
                                        backgroundColor: d
                                    }]
                                }
                            })
                        }
                        if (document.getElementById("areaChartNoShadow")) {
                            var q = document.getElementById("areaChartNoShadow").getContext("2d");
                            new Chart(q, {
                                type: "line",
                                options: {
                                    plugins: {
                                        datalabels: {
                                            display: !1
                                        }
                                    },
                                    responsive: !0,
                                    maintainAspectRatio: !1,
                                    scales: {
                                        yAxes: [{
                                            gridLines: {
                                                display: !0,
                                                lineWidth: 1,
                                                color: "rgba(0,0,0,0.1)",
                                                drawBorder: !1
                                            },
                                            ticks: {
                                                beginAtZero: !0,
                                                stepSize: 5,
                                                min: 50,
                                                max: 70,
                                                padding: 0
                                            }
                                        }],
                                        xAxes: [{
                                            gridLines: {
                                                display: !1
                                            }
                                        }]
                                    },
                                    legend: {
                                        display: !1
                                    },
                                    tooltips: T
                                },
                                data: {
                                    labels: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
                                    datasets: [{
                                        label: "",
                                        data: [54, 63, 60, 65, 60, 68, 60],
                                        borderColor: t,
                                        pointBackgroundColor: g,
                                        pointBorderColor: t,
                                        pointHoverBackgroundColor: t,
                                        pointHoverBorderColor: g,
                                        pointRadius: 4,
                                        pointBorderWidth: 2,
                                        pointHoverRadius: 5,
                                        fill: !0,
                                        borderWidth: 2,
                                        backgroundColor: d
                                    }]
                                }
                            })
                        }
                        if (document.getElementById("scatterChart")) {
                            var _ = document.getElementById("scatterChart").getContext("2d");
                            new Chart(_, {
                                type: "ScatterWithShadow",
                                options: {
                                    plugins: {
                                        datalabels: {
                                            display: !1
                                        }
                                    },
                                    responsive: !0,
                                    maintainAspectRatio: !1,
                                    scales: {
                                        yAxes: [{
                                            gridLines: {
                                                display: !0,
                                                lineWidth: 1,
                                                color: "rgba(0,0,0,0.1)",
                                                drawBorder: !1
                                            },
                                            ticks: {
                                                beginAtZero: !0,
                                                stepSize: 20,
                                                min: -80,
                                                max: 80,
                                                padding: 20
                                            }
                                        }],
                                        xAxes: [{
                                            gridLines: {
                                                display: !0,
                                                lineWidth: 1,
                                                color: "rgba(0,0,0,0.1)"
                                            }
                                        }]
                                    },
                                    legend: {
                                        position: "bottom",
                                        labels: {
                                            padding: 30,
                                            usePointStyle: !0,
                                            fontSize: 12
                                        }
                                    },
                                    tooltips: T
                                },
                                data: {
                                    datasets: [{
                                        borderWidth: 2,
                                        label: "Cakes",
                                        borderColor: t,
                                        backgroundColor: d,
                                        data: [{
                                            x: 62,
                                            y: -78
                                        }, {
                                            x: -0,
                                            y: 74
                                        }, {
                                            x: -67,
                                            y: 45
                                        }, {
                                            x: -26,
                                            y: -43
                                        }, {
                                            x: -15,
                                            y: -30
                                        }, {
                                            x: 65,
                                            y: -68
                                        }, {
                                            x: -28,
                                            y: -61
                                        }]
                                    }, {
                                        borderWidth: 2,
                                        label: "Desserts",
                                        borderColor: i,
                                        backgroundColor: c,
                                        data: [{
                                            x: 79,
                                            y: 62
                                        }, {
                                            x: 62,
                                            y: 0
                                        }, {
                                            x: -76,
                                            y: -81
                                        }, {
                                            x: -51,
                                            y: 41
                                        }, {
                                            x: -9,
                                            y: 9
                                        }, {
                                            x: 72,
                                            y: -37
                                        }, {
                                            x: 62,
                                            y: -26
                                        }]
                                    }]
                                }
                            })
                        }
                        if (document.getElementById("scatterChartNoShadow")) {
                            var V = document.getElementById("scatterChartNoShadow").getContext("2d");
                            new Chart(V, {
                                type: "scatter",
                                options: {
                                    plugins: {
                                        datalabels: {
                                            display: !1
                                        }
                                    },
                                    responsive: !0,
                                    maintainAspectRatio: !1,
                                    scales: {
                                        yAxes: [{
                                            gridLines: {
                                                display: !0,
                                                lineWidth: 1,
                                                color: "rgba(0,0,0,0.1)",
                                                drawBorder: !1
                                            },
                                            ticks: {
                                                beginAtZero: !0,
                                                stepSize: 20,
                                                min: -80,
                                                max: 80,
                                                padding: 20
                                            }
                                        }],
                                        xAxes: [{
                                            gridLines: {
                                                display: !0,
                                                lineWidth: 1,
                                                color: "rgba(0,0,0,0.1)"
                                            }
                                        }]
                                    },
                                    legend: {
                                        position: "bottom",
                                        labels: {
                                            padding: 30,
                                            usePointStyle: !0,
                                            fontSize: 12
                                        }
                                    },
                                    tooltips: T
                                },
                                data: {
                                    datasets: [{
                                        borderWidth: 2,
                                        label: "Cakes",
                                        borderColor: t,
                                        backgroundColor: d,
                                        data: [{
                                            x: 62,
                                            y: -78
                                        }, {
                                            x: -0,
                                            y: 74
                                        }, {
                                            x: -67,
                                            y: 45
                                        }, {
                                            x: -26,
                                            y: -43
                                        }, {
                                            x: -15,
                                            y: -30
                                        }, {
                                            x: 65,
                                            y: -68
                                        }, {
                                            x: -28,
                                            y: -61
                                        }]
                                    }, {
                                        borderWidth: 2,
                                        label: "Desserts",
                                        borderColor: i,
                                        backgroundColor: c,
                                        data: [{
                                            x: 79,
                                            y: 62
                                        }, {
                                            x: 62,
                                            y: 0
                                        }, {
                                            x: -76,
                                            y: -81
                                        }, {
                                            x: -51,
                                            y: 41
                                        }, {
                                            x: -9,
                                            y: 9
                                        }, {
                                            x: 72,
                                            y: -37
                                        }, {
                                            x: 62,
                                            y: -26
                                        }]
                                    }]
                                }
                            })
                        }
                        if (document.getElementById("radarChartNoShadow")) {
                            var Z = document.getElementById("radarChartNoShadow").getContext("2d");
                            new Chart(Z, {
                                type: "radar",
                                options: {
                                    plugins: {
                                        datalabels: {
                                            display: !1
                                        }
                                    },
                                    responsive: !0,
                                    maintainAspectRatio: !1,
                                    scale: {
                                        ticks: {
                                            display: !1
                                        }
                                    },
                                    legend: {
                                        position: "bottom",
                                        labels: {
                                            padding: 30,
                                            usePointStyle: !0,
                                            fontSize: 12
                                        }
                                    },
                                    tooltips: T
                                },
                                data: {
                                    datasets: [{
                                        label: "Stock",
                                        borderWidth: 2,
                                        pointBackgroundColor: t,
                                        borderColor: t,
                                        backgroundColor: d,
                                        data: [80, 90, 70]
                                    }, {
                                        label: "Order",
                                        borderWidth: 2,
                                        pointBackgroundColor: i,
                                        borderColor: i,
                                        backgroundColor: c,
                                        data: [68, 80, 95]
                                    }],
                                    labels: ["Cakes", "Desserts", "Cupcakes"]
                                }
                            })
                        }
                        if (document.getElementById("radarChart")) {
                            var J = document.getElementById("radarChart").getContext("2d");
                            new Chart(J, {
                                type: "RadarWithShadow",
                                options: {
                                    plugins: {
                                        datalabels: {
                                            display: !1
                                        }
                                    },
                                    responsive: !0,
                                    maintainAspectRatio: !1,
                                    scale: {
                                        ticks: {
                                            display: !1
                                        }
                                    },
                                    legend: {
                                        position: "bottom",
                                        labels: {
                                            padding: 30,
                                            usePointStyle: !0,
                                            fontSize: 12
                                        }
                                    },
                                    tooltips: T
                                },
                                data: {
                                    datasets: [{
                                        label: "Stock",
                                        borderWidth: 2,
                                        pointBackgroundColor: t,
                                        borderColor: t,
                                        backgroundColor: d,
                                        data: [80, 90, 70]
                                    }, {
                                        label: "Order",
                                        borderWidth: 2,
                                        pointBackgroundColor: i,
                                        borderColor: i,
                                        backgroundColor: c,
                                        data: [68, 80, 95]
                                    }],
                                    labels: ["Cakes", "Desserts", "Cupcakes"]
                                }
                            })
                        }
                        if (document.getElementById("polarChart")) {
                            var U = document.getElementById("polarChart").getContext("2d");
                            new Chart(U, {
                                type: "PolarWithShadow",
                                options: {
                                    plugins: {
                                        datalabels: {
                                            display: !1
                                        }
                                    },
                                    responsive: !0,
                                    maintainAspectRatio: !1,
                                    scale: {
                                        ticks: {
                                            display: !1
                                        }
                                    },
                                    legend: {
                                        position: "bottom",
                                        labels: {
                                            padding: 30,
                                            usePointStyle: !0,
                                            fontSize: 12
                                        }
                                    },
                                    tooltips: T
                                },
                                data: {
                                    datasets: [{
                                        label: "Stock",
                                        borderWidth: 2,
                                        pointBackgroundColor: t,
                                        borderColor: [t, i, r],
                                        backgroundColor: [d, c, u],
                                        data: [80, 90, 70]
                                    }],
                                    labels: ["Cakes", "Desserts", "Cupcakes"]
                                }
                            })
                        }
                        if (document.getElementById("polarChartNoShadow")) {
                            var Y = document.getElementById("polarChartNoShadow").getContext("2d");
                            new Chart(Y, {
                                type: "polarArea",
                                options: {
                                    plugins: {
                                        datalabels: {
                                            display: !1
                                        }
                                    },
                                    responsive: !0,
                                    maintainAspectRatio: !1,
                                    scale: {
                                        ticks: {
                                            display: !1
                                        }
                                    },
                                    legend: {
                                        position: "bottom",
                                        labels: {
                                            padding: 30,
                                            usePointStyle: !0,
                                            fontSize: 12
                                        }
                                    },
                                    tooltips: T
                                },
                                data: {
                                    datasets: [{
                                        label: "Stock",
                                        borderWidth: 2,
                                        pointBackgroundColor: t,
                                        borderColor: [t, i, r],
                                        backgroundColor: [d, c, u],
                                        data: [80, 90, 70]
                                    }],
                                    labels: ["Cakes", "Desserts", "Cupcakes"]
                                }
                            })
                        }
                        if (document.getElementById("salesChartNoShadow")) {
                            var $ = document.getElementById("salesChartNoShadow").getContext("2d");
                            new Chart($, {
                                type: "line",
                                options: {
                                    plugins: {
                                        datalabels: {
                                            display: !1
                                        }
                                    },
                                    responsive: !0,
                                    maintainAspectRatio: !1,
                                    scales: {
                                        yAxes: [{
                                            gridLines: {
                                                display: !0,
                                                lineWidth: 1,
                                                color: "rgba(0,0,0,0.1)",
                                                drawBorder: !1
                                            },
                                            ticks: {
                                                beginAtZero: !0,
                                                stepSize: 5,
                                                min: 50,
                                                max: 70,
                                                padding: 20
                                            }
                                        }],
                                        xAxes: [{
                                            gridLines: {
                                                display: !1
                                            }
                                        }]
                                    },
                                    legend: {
                                        display: !1
                                    },
                                    tooltips: T
                                },
                                data: {
                                    labels: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
                                    datasets: [{
                                        label: "",
                                        data: [54, 63, 60, 65, 60, 68, 60],
                                        borderColor: t,
                                        pointBackgroundColor: g,
                                        pointBorderColor: t,
                                        pointHoverBackgroundColor: t,
                                        pointHoverBorderColor: g,
                                        pointRadius: 6,
                                        pointBorderWidth: 2,
                                        pointHoverRadius: 8,
                                        fill: !1
                                    }]
                                }
                            })
                        }
                        if (document.getElementById("productChart")) {
                            var X = document.getElementById("productChart").getContext("2d");
                            new Chart(X, {
                                type: "BarWithShadow",
                                options: {
                                    plugins: {
                                        datalabels: {
                                            display: !1
                                        }
                                    },
                                    responsive: !0,
                                    maintainAspectRatio: !1,
                                    scales: {
                                        yAxes: [{
                                            gridLines: {
                                                display: !0,
                                                lineWidth: 1,
                                                color: "rgba(0,0,0,0.1)",
                                                drawBorder: !1
                                            },
                                            ticks: {
                                                beginAtZero: !0,
                                                stepSize: 100,
                                                min: 300,
                                                max: 800,
                                                padding: 20
                                            }
                                        }],
                                        xAxes: [{
                                            gridLines: {
                                                display: !1
                                            }
                                        }]
                                    },
                                    legend: {
                                        position: "bottom",
                                        labels: {
                                            padding: 30,
                                            usePointStyle: !0,
                                            fontSize: 12
                                        }
                                    },
                                    tooltips: T
                                },
                                data: {
                                    labels: ["January", "February", "March", "April", "May", "June"],
                                    datasets: [{
                                        label: "Cakes",
                                        borderColor: t,
                                        backgroundColor: d,
                                        data: [456, 479, 324, 569, 702, 600],
                                        borderWidth: 2
                                    }, {
                                        label: "Desserts",
                                        borderColor: i,
                                        backgroundColor: c,
                                        data: [364, 504, 605, 400, 345, 320],
                                        borderWidth: 2
                                    }]
                                }
                            })
                        }
                        if (document.getElementById("productChartNoShadow")) {
                            var j = document.getElementById("productChartNoShadow").getContext("2d");
                            new Chart(j, {
                                type: "bar",
                                options: {
                                    plugins: {
                                        datalabels: {
                                            display: !1
                                        }
                                    },
                                    responsive: !0,
                                    maintainAspectRatio: !1,
                                    scales: {
                                        yAxes: [{
                                            gridLines: {
                                                display: !0,
                                                lineWidth: 1,
                                                color: "rgba(0,0,0,0.1)",
                                                drawBorder: !1
                                            },
                                            ticks: {
                                                beginAtZero: !0,
                                                stepSize: 100,
                                                min: 300,
                                                max: 800,
                                                padding: 20
                                            }
                                        }],
                                        xAxes: [{
                                            gridLines: {
                                                display: !1
                                            }
                                        }]
                                    },
                                    legend: {
                                        position: "bottom",
                                        labels: {
                                            padding: 30,
                                            usePointStyle: !0,
                                            fontSize: 12
                                        }
                                    },
                                    tooltips: T
                                },
                                data: {
                                    labels: ["January", "February", "March", "April", "May", "June"],
                                    datasets: [{
                                        label: "Cakes",
                                        borderColor: t,
                                        backgroundColor: d,
                                        data: [456, 479, 324, 569, 702, 600],
                                        borderWidth: 2
                                    }, {
                                        label: "Desserts",
                                        borderColor: i,
                                        backgroundColor: c,
                                        data: [364, 504, 605, 400, 345, 320],
                                        borderWidth: 2
                                    }]
                                }
                            })
                        }
                        var K = {
                            type: "LineWithShadow",
                            options: {
                                plugins: {
                                    datalabels: {
                                        display: !1
                                    }
                                },
                                responsive: !0,
                                maintainAspectRatio: !1,
                                scales: {
                                    yAxes: [{
                                        gridLines: {
                                            display: !0,
                                            lineWidth: 1,
                                            color: "rgba(0,0,0,0.1)",
                                            drawBorder: !1
                                        },
                                        ticks: {
                                            beginAtZero: !0,
                                            stepSize: 5,
                                            min: 50,
                                            max: 70,
                                            padding: 20
                                        }
                                    }],
                                    xAxes: [{
                                        gridLines: {
                                            display: !1
                                        }
                                    }]
                                },
                                legend: {
                                    display: !1
                                },
                                tooltips: T
                            },
                            data: {
                                labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                                datasets: [{
                                    borderWidth: 2,
                                    label: "",
                                    data: [54, 63, 60, 65, 60, 68, 60, 63, 60, 65, 60, 68],
                                    borderColor: t,
                                    pointBackgroundColor: g,
                                    pointBorderColor: t,
                                    pointHoverBackgroundColor: t,
                                    pointHoverBorderColor: g,
                                    pointRadius: 4,
                                    pointBorderWidth: 2,
                                    pointHoverRadius: 5,
                                    fill: !1
                                }]
                            }
                        };
                        document.getElementById("contributionChart1") && new Chart(document.getElementById("contributionChart1").getContext("2d"), K), document.getElementById("contributionChart2") && new Chart(document.getElementById("contributionChart2").getContext("2d"), K), document.getElementById("contributionChart3") && new Chart(document.getElementById("contributionChart3").getContext("2d"), K);
                        var Q = {
                            afterDatasetsUpdate: function(e) {},
                            beforeDraw: function(e) {
                                var t = e.chartArea.right,
                                    a = e.chartArea.bottom,
                                    o = e.chart.ctx;
                                o.restore();
                                var n = e.data.labels[0],
                                    i = e.data.datasets[0].data[0],
                                    r = e.data.datasets[0],
                                    s = r._meta[Object.keys(r._meta)[0]],
                                    l = s.total,
                                    d = parseFloat((i / l * 100).toFixed(1));
                                d = e.legend.legendItems[0].hidden ? 0 : d, e.pointAvailable && (n = e.data.labels[e.pointIndex], i = e.data.datasets[e.pointDataIndex].data[e.pointIndex], l = (s = (r = e.data.datasets[e.pointDataIndex])._meta[Object.keys(r._meta)[0]]).total, d = parseFloat((i / l * 100).toFixed(1)), d = e.legend.legendItems[e.pointIndex].hidden ? 0 : d), o.font = "36px Nunito, sans-serif", o.fillStyle = m, o.textBaseline = "middle";
                                var c = d + "%",
                                    u = Math.round((t - o.measureText(c).width) / 2),
                                    p = a / 2;
                                o.fillText(c, u, p), o.font = "14px Nunito, sans-serif", o.textBaseline = "middle";
                                var h = n;
                                u = Math.round((t - o.measureText(h).width) / 2), p = a / 2 - 30, o.fillText(h, u, p), o.save()
                            },
                            beforeEvent: function(e, t, a) {
                                var o = e.getElementAtEvent(t)[0];
                                o && (e.pointIndex = o._index, e.pointDataIndex = o._datasetIndex, e.pointAvailable = !0)
                            }
                        };
                        if (document.getElementById("categoryChart")) {
                            var G = document.getElementById("categoryChart");
                            new Chart(G, {
                                plugins: [Q],
                                type: "DoughnutWithShadow",
                                data: {
                                    labels: ["Cakes", "Cupcakes", "Desserts"],
                                    datasets: [{
                                        label: "",
                                        borderColor: [r, i, t],
                                        backgroundColor: [u, c, d],
                                        borderWidth: 2,
                                        data: [15, 25, 20]
                                    }]
                                },
                                draw: function() {},
                                options: {
                                    plugins: {
                                        datalabels: {
                                            display: !1
                                        }
                                    },
                                    responsive: !0,
                                    maintainAspectRatio: !1,
                                    cutoutPercentage: 80,
                                    title: {
                                        display: !1
                                    },
                                    layout: {
                                        padding: {
                                            bottom: 20
                                        }
                                    },
                                    legend: {
                                        position: "bottom",
                                        labels: {
                                            padding: 30,
                                            usePointStyle: !0,
                                            fontSize: 12
                                        }
                                    },
                                    tooltips: T
                                }
                            })
                        }
                        if (document.getElementById("categoryChartNoShadow")) {
                            var ee = document.getElementById("categoryChartNoShadow");
                            new Chart(ee, {
                                plugins: [Q],
                                type: "doughnut",
                                data: {
                                    labels: ["Cakes", "Cupcakes", "Desserts"],
                                    datasets: [{
                                        label: "",
                                        borderColor: [r, i, t],
                                        backgroundColor: [u, c, d],
                                        borderWidth: 2,
                                        data: [15, 25, 20]
                                    }]
                                },
                                draw: function() {},
                                options: {
                                    plugins: {
                                        datalabels: {
                                            display: !1
                                        }
                                    },
                                    responsive: !0,
                                    maintainAspectRatio: !1,
                                    cutoutPercentage: 80,
                                    title: {
                                        display: !1
                                    },
                                    layout: {
                                        padding: {
                                            bottom: 20
                                        }
                                    },
                                    legend: {
                                        position: "bottom",
                                        labels: {
                                            padding: 30,
                                            usePointStyle: !0,
                                            fontSize: 12
                                        }
                                    },
                                    tooltips: T
                                }
                            })
                        }
                        if (document.getElementById("pieChartNoShadow")) {
                            var te = document.getElementById("pieChartNoShadow");
                            new Chart(te, {
                                type: "pie",
                                data: {
                                    labels: ["Cakes", "Cupcakes", "Desserts"],
                                    datasets: [{
                                        label: "",
                                        borderColor: [t, i, r],
                                        backgroundColor: [d, c, u],
                                        borderWidth: 2,
                                        data: [15, 25, 20]
                                    }]
                                },
                                draw: function() {},
                                options: {
                                    plugins: {
                                        datalabels: {
                                            display: !1
                                        }
                                    },
                                    responsive: !0,
                                    maintainAspectRatio: !1,
                                    title: {
                                        display: !1
                                    },
                                    layout: {
                                        padding: {
                                            bottom: 20
                                        }
                                    },
                                    legend: {
                                        position: "bottom",
                                        labels: {
                                            padding: 30,
                                            usePointStyle: !0,
                                            fontSize: 12
                                        }
                                    },
                                    tooltips: T
                                }
                            })
                        }
                        if (document.getElementById("pieChart") && (te = document.getElementById("pieChart"), new Chart(te, {
                            type: "PieWithShadow",
                            data: {
                                labels: ["Cakes", "Cupcakes", "Desserts"],
                                datasets: [{
                                    label: "",
                                    borderColor: [t, i, r],
                                    backgroundColor: [d, c, u],
                                    borderWidth: 2,
                                    data: [15, 25, 20]
                                }]
                            },
                            draw: function() {},
                            options: {
                                plugins: {
                                    datalabels: {
                                        display: !1
                                    }
                                },
                                responsive: !0,
                                maintainAspectRatio: !1,
                                title: {
                                    display: !1
                                },
                                layout: {
                                    padding: {
                                        bottom: 20
                                    }
                                },
                                legend: {
                                    position: "bottom",
                                    labels: {
                                        padding: 30,
                                        usePointStyle: !0,
                                        fontSize: 12
                                    }
                                },
                                tooltips: T
                            }
                        })), document.getElementById("frequencyChart")) {
                            var ae = document.getElementById("frequencyChart");
                            new Chart(ae, {
                                plugins: [Q],
                                type: "DoughnutWithShadow",
                                data: {
                                    labels: ["Adding", "Editing", "Deleting"],
                                    datasets: [{
                                        label: "",
                                        borderColor: [t, i, r],
                                        backgroundColor: [d, c, u],
                                        borderWidth: 2,
                                        data: [15, 25, 20]
                                    }]
                                },
                                draw: function() {},
                                options: {
                                    plugins: {
                                        datalabels: {
                                            display: !1
                                        }
                                    },
                                    responsive: !0,
                                    maintainAspectRatio: !1,
                                    cutoutPercentage: 80,
                                    title: {
                                        display: !1
                                    },
                                    layout: {
                                        padding: {
                                            bottom: 20
                                        }
                                    },
                                    legend: {
                                        position: "bottom",
                                        labels: {
                                            padding: 30,
                                            usePointStyle: !0,
                                            fontSize: 12
                                        }
                                    },
                                    tooltips: T
                                }
                            })
                        }
                        if (document.getElementById("ageChart")) {
                            var oe = document.getElementById("ageChart");
                            new Chart(oe, {
                                plugins: [Q],
                                type: "DoughnutWithShadow",
                                data: {
                                    labels: ["12-24", "24-30", "30-40", "40-50", "50-60"],
                                    datasets: [{
                                        label: "",
                                        borderColor: [t, i, r, s, l],
                                        backgroundColor: [d, c, u, p, h],
                                        borderWidth: 2,
                                        data: [15, 25, 20, 30, 14]
                                    }]
                                },
                                draw: function() {},
                                options: {
                                    plugins: {
                                        datalabels: {
                                            display: !1
                                        }
                                    },
                                    responsive: !0,
                                    maintainAspectRatio: !1,
                                    cutoutPercentage: 80,
                                    title: {
                                        display: !1
                                    },
                                    layout: {
                                        padding: {
                                            bottom: 20
                                        }
                                    },
                                    legend: {
                                        position: "bottom",
                                        labels: {
                                            padding: 30,
                                            usePointStyle: !0,
                                            fontSize: 12
                                        }
                                    },
                                    tooltips: T
                                }
                            })
                        }
                        if (document.getElementById("genderChart")) {
                            var ne = document.getElementById("genderChart");
                            new Chart(ne, {
                                plugins: [Q],
                                type: "DoughnutWithShadow",
                                data: {
                                    labels: ["Male", "Female", "Other"],
                                    datasets: [{
                                        label: "",
                                        borderColor: [t, i, r],
                                        backgroundColor: [d, c, u],
                                        borderWidth: 2,
                                        data: [85, 45, 20]
                                    }]
                                },
                                draw: function() {},
                                options: {
                                    plugins: {
                                        datalabels: {
                                            display: !1
                                        }
                                    },
                                    responsive: !0,
                                    maintainAspectRatio: !1,
                                    cutoutPercentage: 80,
                                    title: {
                                        display: !1
                                    },
                                    layout: {
                                        padding: {
                                            bottom: 20
                                        }
                                    },
                                    legend: {
                                        position: "bottom",
                                        labels: {
                                            padding: 30,
                                            usePointStyle: !0,
                                            fontSize: 12
                                        }
                                    },
                                    tooltips: T
                                }
                            })
                        }
                        if (document.getElementById("workChart")) {
                            var ie = document.getElementById("workChart");
                            new Chart(ie, {
                                plugins: [Q],
                                type: "DoughnutWithShadow",
                                data: {
                                    labels: ["Employed for wages", "Self-employed", "Looking for work", "Retired"],
                                    datasets: [{
                                        label: "",
                                        borderColor: [t, i, r, s],
                                        backgroundColor: [d, c, u, p],
                                        borderWidth: 2,
                                        data: [15, 25, 20, 8]
                                    }]
                                },
                                draw: function() {},
                                options: {
                                    plugins: {
                                        datalabels: {
                                            display: !1
                                        }
                                    },
                                    responsive: !0,
                                    maintainAspectRatio: !1,
                                    cutoutPercentage: 80,
                                    title: {
                                        display: !1
                                    },
                                    layout: {
                                        padding: {
                                            bottom: 20
                                        }
                                    },
                                    legend: {
                                        position: "bottom",
                                        labels: {
                                            padding: 30,
                                            usePointStyle: !0,
                                            fontSize: 12
                                        }
                                    },
                                    tooltips: T
                                }
                            })
                        }
                        if (document.getElementById("codingChart")) {
                            var re = document.getElementById("codingChart");
                            new Chart(re, {
                                plugins: [Q],
                                type: "DoughnutWithShadow",
                                data: {
                                    labels: ["Python", "JavaScript", "PHP", "Java", "C#"],
                                    datasets: [{
                                        label: "",
                                        borderColor: [t, i, r, s, l],
                                        backgroundColor: [d, c, u, p, h],
                                        borderWidth: 2,
                                        data: [15, 25, 20, 8, 25]
                                    }]
                                },
                                draw: function() {},
                                options: {
                                    plugins: {
                                        datalabels: {
                                            display: !1
                                        }
                                    },
                                    responsive: !0,
                                    maintainAspectRatio: !1,
                                    cutoutPercentage: 80,
                                    title: {
                                        display: !1
                                    },
                                    layout: {
                                        padding: {
                                            bottom: 20
                                        }
                                    },
                                    legend: {
                                        position: "bottom",
                                        labels: {
                                            padding: 30,
                                            usePointStyle: !0,
                                            fontSize: 12
                                        }
                                    },
                                    tooltips: T
                                }
                            })
                        }
                    }
                    if (o().fullCalendar) {
                        var se = new Date((new Date).setHours((new Date).getHours()));
                        se.getDate(), se.getMonth(), o(".calendar").fullCalendar({
                            themeSystem: "bootstrap4",
                            height: "auto",
                            buttonText: {
                                today: "Today",
                                month: "Month",
                                week: "Week",
                                day: "Day",
                                list: "List"
                            },
                            bootstrapFontAwesome: {
                                prev: " simple-icon-arrow-left",
                                next: " simple-icon-arrow-right",
                                prevYear: "simple-icon-control-start",
                                nextYear: "simple-icon-control-end"
                            },
                            events: [{
                                title: "Account",
                                start: "2018-05-18"
                            }, {
                                title: "Delivery",
                                start: "2018-09-22",
                                end: "2018-09-24"
                            }, {
                                title: "Conference",
                                start: "2018-06-07",
                                end: "2018-06-09"
                            }, {
                                title: "Delivery",
                                start: "2018-11-03",
                                end: "2018-11-06"
                            }, {
                                title: "Meeting",
                                start: "2018-10-07",
                                end: "2018-10-09"
                            }, {
                                title: "Taxes",
                                start: "2018-08-07",
                                end: "2018-08-09"
                            }]
                        })
                    }
                    o().DataTable && o(".data-table").DataTable({
                        searching: !1,
                        bLengthChange: !1,
                        destroy: !0,
                        info: !1,
                        sDom: '<"row view-filter"<"col-sm-12"<"pull-left"l><"pull-right"f><"clearfix">>>t<"row view-pager"<"col-sm-12"<"text-center"ip>>>',
                        pageLength: 6,
                        language: {
                            paginate: {
                                previous: "<i class='simple-icon-arrow-left'></i>",
                                next: "<i class='simple-icon-arrow-right'></i>"
                            }
                        },
                        drawCallback: function() {
                            o(o(".dataTables_wrapper .pagination li:first-of-type")).find("a").addClass("prev"), o(o(".dataTables_wrapper .pagination li:last-of-type")).find("a").addClass("next"), o(".dataTables_wrapper .pagination").addClass("pagination-sm")
                        }
                    }), o("body").on("click", ".notify-btn", function(e) {
                        var t, a, n;
                        e.preventDefault(), t = o(this).data("from"), a = o(this).data("align"), n = "primary", o.notify({
                            title: "Bootstrap Notify",
                            message: "Here is a notification!",
                            target: "_blank"
                        }, {
                            element: "body",
                            position: null,
                            type: n,
                            allow_dismiss: !0,
                            newest_on_top: !1,
                            showProgressbar: !1,
                            placement: {
                                from: t,
                                align: a
                            },
                            offset: 20,
                            spacing: 10,
                            z_index: 1031,
                            delay: 4e3,
                            timer: 2e3,
                            url_target: "_blank",
                            mouse_over: null,
                            animate: {
                                enter: "animated fadeInDown",
                                exit: "animated fadeOutUp"
                            },
                            onShow: null,
                            onShown: null,
                            onClose: null,
                            onClosed: null,
                            icon_type: "class",
                            template: '<div data-notify="container" class="col-11 col-sm-3 alert  alert-{0} " role="alert"><button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button><span data-notify="icon"></span> <span data-notify="title">{1}</span> <span data-notify="message">{2}</span><div class="progress" data-notify="progressbar"><div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div></div><a href="{3}" target="{4}" data-notify="url"></a></div>'
                        })
                    }), o().owlCarousel && (o(".owl-carousel.basic").length > 0 && o(".owl-carousel.basic").owlCarousel({
                        margin: 30,
                        stagePadding: 15,
                        dotsContainer: o(".owl-carousel.basic").parents(".owl-container").find(".slider-dot-container"),
                        responsive: {
                            0: {
                                items: 1
                            },
                            600: {
                                items: 2
                            },
                            1000: {
                                items: 3
                            }
                        }
                    }).data("owl.carousel").onResize(), o(".owl-carousel.dashboard-numbers").length > 0 && o(".owl-carousel.dashboard-numbers").owlCarousel({
                        margin: 15,
                        loop: !0,
                        autoplay: !0,
                        stagePadding: 5,
                        responsive: {
                            0: {
                                items: 1
                            },
                            320: {
                                items: 2
                            },
                            576: {
                                items: 3
                            },
                            1200: {
                                items: 3
                            },
                            1440: {
                                items: 3
                            },
                            1800: {
                                items: 4
                            }
                        }
                    }).data("owl.carousel").onResize(), o(".best-rated-items").length > 0 && o(".best-rated-items").owlCarousel({
                        margin: 15,
                        items: 1,
                        loop: !0,
                        autoWidth: !0
                    }).data("owl.carousel").onResize(), o(".owl-carousel.single").length > 0 && o(".owl-carousel.single").owlCarousel({
                        margin: 30,
                        items: 1,
                        loop: !0,
                        stagePadding: 15,
                        dotsContainer: o(".owl-carousel.single").parents(".owl-container").find(".slider-dot-container")
                    }).data("owl.carousel").onResize(), o(".owl-carousel.center").length > 0 && o(".owl-carousel.center").owlCarousel({
                        loop: !0,
                        margin: 30,
                        stagePadding: 15,
                        center: !0,
                        dotsContainer: o(".owl-carousel.center").parents(".owl-container").find(".slider-dot-container"),
                        responsive: {
                            0: {
                                items: 1
                            },
                            480: {
                                items: 2
                            },
                            600: {
                                items: 3
                            },
                            1000: {
                                items: 4
                            }
                        }
                    }).data("owl.carousel").onResize(), o(".owl-dot").click(function() {
                        o(o(this).parents(".owl-container").find(".owl-carousel")).owlCarousel().trigger("to.owl.carousel", [o(this).index(), 300])
                    }), o(".owl-prev").click(function(e) {
                        e.preventDefault(), o(o(this).parents(".owl-container").find(".owl-carousel")).owlCarousel().trigger("prev.owl.carousel", [300])
                    }), o(".owl-next").click(function(e) {
                        e.preventDefault(), o(o(this).parents(".owl-container").find(".owl-carousel")).owlCarousel().trigger("next.owl.carousel", [300])
                    })), o().slick && (o(".slick.basic").slick({
                        dots: !0,
                        infinite: !0,
                        speed: 300,
                        slidesToShow: 3,
                        slidesToScroll: 4,
                        appendDots: o(".slick.basic").parents(".slick-container").find(".slider-dot-container"),
                        prevArrow: o(".slick.basic").parents(".slick-container").find(".slider-nav .left-arrow"),
                        nextArrow: o(".slick.basic").parents(".slick-container").find(".slider-nav .right-arrow"),
                        customPaging: function(e, t) {
                            return '<button role="button" class="slick-dot"><span></span></button>'
                        },
                        responsive: [{
                            breakpoint: 1024,
                            settings: {
                                slidesToShow: 2,
                                slidesToScroll: 2,
                                infinite: !0,
                                dots: !0
                            }
                        }, {
                            breakpoint: 600,
                            settings: {
                                slidesToShow: 1,
                                slidesToScroll: 1
                            }
                        }]
                    }), o(".slick.center").slick({
                        dots: !0,
                        infinite: !0,
                        centerMode: !0,
                        speed: 300,
                        slidesToShow: 4,
                        slidesToScroll: 4,
                        appendDots: o(".slick.center").parents(".slick-container").find(".slider-dot-container"),
                        prevArrow: o(".slick.center").parents(".slick-container").find(".slider-nav .left-arrow"),
                        nextArrow: o(".slick.center").parents(".slick-container").find(".slider-nav .right-arrow"),
                        customPaging: function(e, t) {
                            return '<button role="button" class="slick-dot"><span></span></button>'
                        },
                        responsive: [{
                            breakpoint: 992,
                            settings: {
                                slidesToShow: 3,
                                slidesToScroll: 3,
                                infinite: !0,
                                dots: !0,
                                centerMode: !1
                            }
                        }, {
                            breakpoint: 600,
                            settings: {
                                slidesToShow: 2,
                                slidesToScroll: 2,
                                centerMode: !1
                            }
                        }, {
                            breakpoint: 480,
                            settings: {
                                slidesToShow: 1,
                                slidesToScroll: 1,
                                centerMode: !1
                            }
                        }]
                    }), o(".slick.single").slick({
                        dots: !0,
                        infinite: !0,
                        speed: 300,
                        appendDots: o(".slick.single").parents(".slick-container").find(".slider-dot-container"),
                        prevArrow: o(".slick.single").parents(".slick-container").find(".slider-nav .left-arrow"),
                        nextArrow: o(".slick.single").parents(".slick-container").find(".slider-nav .right-arrow"),
                        customPaging: function(e, t) {
                            return '<button role="button" class="slick-dot"><span></span></button>'
                        }
                    }));
                    var le = document.getElementsByClassName("needs-validation");
                    Array.prototype.filter.call(le, function(e) {
                        e.addEventListener("submit", function(t) {
                            !1 === e.checkValidity() && (t.preventDefault(), t.stopPropagation()), e.classList.add("was-validated")
                        }, !1)
                    }), o().tooltip && o('[data-toggle="tooltip"]').tooltip(), o().popover && o('[data-toggle="popover"]').popover({
                        trigger: "focus"
                    }), o().select2 && o(".select2-single, .select2-multiple").select2({
                        theme: "bootstrap",
                        placeholder: "",
                        maximumSelectionSize: 6,
                        containerCssClass: ":all:"
                    }), o().datepicker && (o("input.datepicker").datepicker({
                        autoclose: !0,
                        templates: {
                            leftArrow: '<i class="simple-icon-arrow-left"></i>',
                            rightArrow: '<i class="simple-icon-arrow-right"></i>'
                        }
                    }), o(".input-daterange").datepicker({
                        autoclose: !0,
                        templates: {
                            leftArrow: '<i class="simple-icon-arrow-left"></i>',
                            rightArrow: '<i class="simple-icon-arrow-right"></i>'
                        }
                    }), o(".input-group.date").datepicker({
                        autoclose: !0,
                        templates: {
                            leftArrow: '<i class="simple-icon-arrow-left"></i>',
                            rightArrow: '<i class="simple-icon-arrow-right"></i>'
                        }
                    }), o(".date-inline").datepicker({
                        autoclose: !0,
                        templates: {
                            leftArrow: '<i class="simple-icon-arrow-left"></i>',
                            rightArrow: '<i class="simple-icon-arrow-right"></i>'
                        }
                    })), o().dropzone && !o(".dropzone").hasClass("disabled") && o(".dropzone").dropzone({
                        url: "/file/post",
                        thumbnailWidth: 160,
                        previewTemplate: '<div class="dz-preview dz-file-preview mb-3"><div class="d-flex flex-row "> <div class="p-0 w-30 position-relative"> <div class="dz-error-mark"><span><i class="simple-icon-exclamation"></i>  </span></div>      <div class="dz-success-mark"><span><i class="simple-icon-check-circle"></i></span></div>      <img data-dz-thumbnail class="img-thumbnail border-0" /> </div> <div class="pl-3 pt-2 pr-2 pb-1 w-70 dz-details position-relative"> <div> <span data-dz-name /> </div> <div class="text-primary text-extra-small" data-dz-size /> </div> <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>        <div class="dz-error-message"><span data-dz-errormessage></span></div>            </div><a href="#" class="remove" data-dz-remove> <i class="simple-icon-trash"></i> </a></div>'
                    });
                    var de, ce = window.Cropper;
                    if (void 0 !== ce) {
                        var ue = function(e, t) {
                                var a, o = e.length;
                                for (a = 0; a < o; a++) t.call(e, e[a], a, e);
                                return e
                            },
                            pe = document.querySelectorAll(".cropper-preview"),
                            he = {
                                aspectRatio: 4 / 3,
                                preview: ".img-preview",
                                ready: function() {
                                    var e = this.cloneNode();
                                    e.className = "", e.style.cssText = "display: block;width: 100%;min-width: 0;min-height: 0;max-width: none;max-height: none;", ue(pe, function(t) {
                                        t.appendChild(e.cloneNode())
                                    })
                                },
                                crop: function(e) {
                                    var t = e.detail,
                                        a = this.cropper.getImageData(),
                                        o = t.width / t.height;
                                    ue(pe, function(e) {
                                        var n = e.getElementsByTagName("img").item(0),
                                            i = e.offsetWidth,
                                            r = i / o,
                                            s = t.width / i;
                                        e.style.height = r + "px", n && (n.style.width = a.naturalWidth / s + "px", n.style.height = a.naturalHeight / s + "px", n.style.marginLeft = -t.x / s + "px", n.style.marginTop = -t.y / s + "px")
                                    })
                                },
                                zoom: function(e) {}
                            };
                        if (o("#inputImage").length > 0) {
                            var me, ge = o("#inputImage")[0],
                                be = o("#cropperImage")[0];
                            ge.onchange = function() {
                                var e, t = this.files;
                                t && t.length && (e = t[0], o("#cropperContainer").css("display", "block"), /^image\/\w+/.test(e.type) ? (uploadedImageType = e.type, uploadedImageName = e.name, be.src = uploadedImageURL = URL.createObjectURL(e), me && me.destroy(), me = new ce(be, he), ge.value = null) : window.alert("Please choose an image file."))
                            }
                        }
                    }

                    function fe() {
                        return document.fullscreenElement && null !== document.fullscreenElement || document.webkitFullscreenElement && null !== document.webkitFullscreenElement || document.mozFullScreenElement && null !== document.mozFullScreenElement || document.msFullscreenElement && null !== document.msFullscreenElement
                    }
                    "undefined" != typeof noUiSlider && (o("#dashboardPriceRange").length > 0 && noUiSlider.create(o("#dashboardPriceRange")[0], {
                        start: [800, 2100],
                        connect: !0,
                        tooltips: !0,
                        range: {
                            min: 200,
                            max: 2800
                        },
                        step: 10,
                        format: {
                            to: function(e) {
                                return "$" + o.fn.addCommas(Math.floor(e))
                            },
                            from: function(e) {
                                return e
                            }
                        }
                    }), o("#doubleSlider").length > 0 && noUiSlider.create(o("#doubleSlider")[0], {
                        start: [800, 1200],
                        connect: !0,
                        tooltips: !0,
                        range: {
                            min: 500,
                            max: 1500
                        },
                        step: 10,
                        format: {
                            to: function(e) {
                                return "$" + o.fn.addCommas(Math.round(e))
                            },
                            from: function(e) {
                                return e
                            }
                        }
                    }), o("#singleSlider").length > 0 && noUiSlider.create(o("#singleSlider")[0], {
                        start: 0,
                        connect: !0,
                        tooltips: !0,
                        range: {
                            min: 0,
                            max: 150
                        },
                        step: 1,
                        format: {
                            to: function(e) {
                                return o.fn.addCommas(Math.round(e))
                            },
                            from: function(e) {
                                return e
                            }
                        }
                    })), o("#exampleModalContent").on("show.bs.modal", function(e) {
                        var t = o(e.relatedTarget).data("whatever"),
                            a = o(this);
                        a.find(".modal-title").text("New message to " + t), a.find(".modal-body input").val(t)
                    }), "undefined" != typeof PerfectScrollbar && o(".scroll").each(function() {
                        if (o(this).parents(".chat-app").length > 0) return de = new PerfectScrollbar(o(this)[0]), o(".chat-app .scroll").scrollTop(o(".chat-app .scroll").prop("scrollHeight")), void de.update();
                        new PerfectScrollbar(o(this)[0])
                    }), o(".progress-bar").each(function() {
                        o(this).css("width", o(this).attr("aria-valuenow") + "%")
                    }), "undefined" != typeof ProgressBar && o(".progress-bar-circle").each(function() {
                        var e = o(this).attr("aria-valuenow"),
                            a = o(this).data("color") || t,
                            n = o(this).data("trailColor") || "#d7d7d7",
                            i = o(this).attr("aria-valuemax") || 100,
                            r = o(this).data("showPercent");
                        new ProgressBar.Circle(this, {
                            color: a,
                            duration: 20,
                            easing: "easeInOut",
                            strokeWidth: 4,
                            trailColor: n,
                            trailWidth: 4,
                            text: {
                                autoStyleContainer: !1
                            },
                            step: function(t, a) {
                                r ? a.setText(Math.round(100 * a.value()) + "%") : a.setText(e + "/" + i)
                            }
                        }).animate(e / i)
                    }), o().barrating && o(".rating").each(function() {
                        var e = o(this).data("currentRating"),
                            t = o(this).data("readonly");
                        o(this).barrating({
                            theme: "bootstrap-stars",
                            initialRating: e,
                            readonly: t
                        })
                    }), o().tagsinput && (o(".tags").tagsinput({
                        cancelConfirmKeysOnEmpty: !0,
                        confirmKeys: [13]
                    }), o("body").on("keypress", ".bootstrap-tagsinput input", function(e) {
                        13 == e.which && (e.preventDefault(), e.stopPropagation())
                    })), "undefined" != typeof Sortable && (o(".sortable").each(function() {
                        o(this).find(".handle").length > 0 ? Sortable.create(o(this)[0], {
                            handle: ".handle"
                        }) : Sortable.create(o(this)[0])
                    }), o(".sortable-survey").length > 0 && Sortable.create(o(".sortable-survey")[0])), o("#successButton").on("click", function(e) {
                        e.preventDefault();
                        var t = o(this);
                        t.hasClass("show-fail") || t.hasClass("show-spinner") || t.hasClass("show-success") || (t.addClass("show-spinner"), t.addClass("active"), setTimeout(function() {
                            t.addClass("show-success"), t.removeClass("show-spinner"), t.find(".icon.success").tooltip("show"), setTimeout(function() {
                                t.removeClass("show-success"), t.removeClass("active"), t.find(".icon.success").tooltip("dispose")
                            }, 2e3)
                        }, 3e3))
                    }), o("#failButton").on("click", function(e) {
                        e.preventDefault();
                        var t = o(this);
                        t.hasClass("show-fail") || t.hasClass("show-spinner") || t.hasClass("show-success") || (t.addClass("show-spinner"), t.addClass("active"), setTimeout(function() {
                            t.addClass("show-fail"), t.removeClass("show-spinner"), t.find(".icon.fail").tooltip("show"), setTimeout(function() {
                                t.removeClass("show-fail"), t.removeClass("active"), t.find(".icon.fail").tooltip("dispose")
                            }, 2e3)
                        }, 3e3))
                    }), o().typeahead && o("#query").typeahead({
                        source: [{
                            name: "May",
                            index: 0,
                            id: "5a8a9bfd8bf389ba8d6bb211"
                        }, {
                            name: "Fuentes",
                            index: 1,
                            id: "5a8a9bfdee10e107f28578d4"
                        }, {
                            name: "Henderson",
                            index: 2,
                            id: "5a8a9bfd4f9e224dfa0110f3"
                        }, {
                            name: "Hinton",
                            index: 3,
                            id: "5a8a9bfde42b28e85df34630"
                        }, {
                            name: "Barrera",
                            index: 4,
                            id: "5a8a9bfdc0cba3abc4532d8d"
                        }, {
                            name: "Therese",
                            index: 5,
                            id: "5a8a9bfdedfcd1aa0f4c414e"
                        }, {
                            name: "Nona",
                            index: 6,
                            id: "5a8a9bfdd6686aa51b953c4e"
                        }, {
                            name: "Frye",
                            index: 7,
                            id: "5a8a9bfd352e2fd4c101507d"
                        }, {
                            name: "Cora",
                            index: 8,
                            id: "5a8a9bfdb5133142047f2600"
                        }, {
                            name: "Miles",
                            index: 9,
                            id: "5a8a9bfdadb1afd136117928"
                        }, {
                            name: "Cantrell",
                            index: 10,
                            id: "5a8a9bfdca4795bcbb002057"
                        }, {
                            name: "Benson",
                            index: 11,
                            id: "5a8a9bfdaa51e9a4aeeddb7d"
                        }, {
                            name: "Susanna",
                            index: 12,
                            id: "5a8a9bfd57dd857535ef5998"
                        }, {
                            name: "Beatrice",
                            index: 13,
                            id: "5a8a9bfd68b6f12828da4175"
                        }, {
                            name: "Tameka",
                            index: 14,
                            id: "5a8a9bfd2bc4a368244d5253"
                        }, {
                            name: "Lowe",
                            index: 15,
                            id: "5a8a9bfd9004fda447204d30"
                        }, {
                            name: "Roth",
                            index: 16,
                            id: "5a8a9bfdb4616dbc06af6172"
                        }, {
                            name: "Conley",
                            index: 17,
                            id: "5a8a9bfdfae43320dd8f9c5a"
                        }, {
                            name: "Nelda",
                            index: 18,
                            id: "5a8a9bfd534d9e0ba2d7c9a7"
                        }, {
                            name: "Angie",
                            index: 19,
                            id: "5a8a9bfd57de84496dc42259"
                        }]
                    }), o("#fullScreenButton").on("click", function(e) {
                        var t, a;
                        e.preventDefault(), fe() ? (o(o(this).find("i")[1]).css("display", "none"), o(o(this).find("i")[0]).css("display", "inline")) : (o(o(this).find("i")[1]).css("display", "inline"), o(o(this).find("i")[0]).css("display", "none")), t = fe(), a = document.documentElement, t ? document.exitFullscreen ? document.exitFullscreen() : document.webkitExitFullscreen ? document.webkitExitFullscreen() : document.mozCancelFullScreen ? document.mozCancelFullScreen() : document.msExitFullscreen && document.msExitFullscreen() : a.requestFullscreen ? a.requestFullscreen() : a.mozRequestFullScreen ? a.mozRequestFullScreen() : a.webkitRequestFullScreen ? a.webkitRequestFullScreen() : a.msRequestFullscreen && a.msRequestFullscreen()
                    }), "undefined" != typeof Quill && (new Quill("#quillEditor", {
                        modules: {
                            toolbar: [
                                ["bold", "italic", "underline", "strike"],
                                ["blockquote", "code-block"],
                                [{
                                    header: 1
                                }, {
                                    header: 2
                                }],
                                [{
                                    list: "ordered"
                                }, {
                                    list: "bullet"
                                }],
                                [{
                                    script: "sub"
                                }, {
                                    script: "super"
                                }],
                                [{
                                    indent: "-1"
                                }, {
                                    indent: "+1"
                                }],
                                [{
                                    direction: "rtl"
                                }],
                                [{
                                    size: ["small", !1, "large", "huge"]
                                }],
                                [{
                                    header: [1, 2, 3, 4, 5, 6, !1]
                                }],
                                [{
                                    color: []
                                }, {
                                    background: []
                                }],
                                [{
                                    font: []
                                }],
                                [{
                                    align: []
                                }],
                                ["clean"]
                            ]
                        },
                        theme: "snow"
                    }), new Quill("#quillEditorBubble", {
                        modules: {
                            toolbar: [
                                ["bold", "italic", "underline", "strike"],
                                [{
                                    list: "ordered"
                                }, {
                                    list: "bullet"
                                }],
                                [{
                                    size: ["small", !1, "large", "huge"]
                                }],
                                [{
                                    color: []
                                }],
                                [{
                                    align: []
                                }]
                            ]
                        },
                        theme: "bubble"
                    }));
                    "undefined" != typeof ClassicEditor && ClassicEditor.create(document.querySelector("#ckEditorClassic")).catch(function(e) {}), o("body > *").stop().delay(100).animate({
                        opacity: 1
                    }, 300), o("body").removeClass("show-spinner"), o("main").addClass("default-transition"), o(".sub-menu").addClass("default-transition"), o(".main-menu").addClass("default-transition"), o(".theme-colors").addClass("default-transition"), "undefined" != typeof Mousetrap && (Mousetrap.bind(["ctrl+down", "command+down"], function(e) {
                        var t = o(".sub-menu li.active").next();
                        return 0 == t.length && (t = o(".sub-menu li.active").parent().children().first()), window.location.href = t.find("a").attr("href"), !1
                    }), Mousetrap.bind(["ctrl+up", "command+up"], function(e) {
                        var t = o(".sub-menu li.active").prev();
                        return 0 == t.length && (t = o(".sub-menu li.active").parent().children().last()), window.location.href = t.find("a").attr("href"), !1
                    }), Mousetrap.bind(["ctrl+shift+down", "command+shift+down"], function(e) {
                        var t = o(".main-menu li.active").next();
                        0 == t.length && (t = o(".main-menu li:first-of-type"));
                        var a = t.find("a").attr("href").replace("#", ""),
                            n = o(".sub-menu ul[data-link='" + a + "'] li:first-of-type");
                        return window.location.href = n.find("a").attr("href"), !1
                    }), Mousetrap.bind(["ctrl+shift+up", "command+shift+up"], function(e) {
                        var t = o(".main-menu li.active").prev();
                        0 == t.length && (t = o(".main-menu li:last-of-type"));
                        var a = t.find("a").attr("href").replace("#", ""),
                            n = o(".sub-menu ul[data-link='" + a + "'] li:first-of-type");
                        return window.location.href = n.find("a").attr("href"), !1
                    }), o(".list") && o(".list").length > 0 && (Mousetrap.bind(["ctrl+a", "command+a"], function(e) {
                        return o(".list").shiftSelectable().data("shiftSelectable").selectAll(), !1
                    }), Mousetrap.bind(["ctrl+d", "command+d"], function(e) {
                        return o(".list").shiftSelectable().data("shiftSelectable").deSelectAll(), !1
                    }))), o().contextMenu && o.contextMenu({
                        selector: ".list .card",
                        callback: function(e, t) {},
                        events: {
                            show: function(e) {
                                var t = e.$trigger.parents(".list");
                                t && t.length > 0 && t.data("shiftSelectable").rightClick(e.$trigger)
                            }
                        },
                        items: {
                            copy: {
                                name: "Copy",
                                className: "simple-icon-docs"
                            },
                            archive: {
                                name: "Move to archive",
                                className: "simple-icon-drawer"
                            },
                            delete: {
                                name: "Delete",
                                className: "simple-icon-trash"
                            }
                        }
                    }), o().selectFromLibrary && (o(".sfl-multiple").selectFromLibrary(), o(".sfl-single").selectFromLibrary())
                }()
            }, o.fn.dore = function(e) {
                return this.each(function() {
                    if (null == o(this).data("dore")) {
                        var t = new o.dore(this, e);
                        o(this).data("dore", t)
                    }
                })
            }
        }
    },
    [
        ["+UE2", "runtime", 0]
    ]
]);(window.webpackJsonp = window.webpackJsonp || []).push([
    ["dore"], {
        "+UE2": function(e, t, a) {
            var o = a("EVdn");
            o.fn.addCommas = function(e) {
                for (var t = (e += "").split("."), a = t[0], o = t.length > 1 ? "." + t[1] : "", n = /(\d+)(\d{3})/; n.test(a);) a = a.replace(n, "$1,$2");
                return a + o
            }, o.shiftSelectable = function(e, t) {
                var a = this;
                t = o.extend({
                    items: ".card"
                }, t);
                var n, i = o(e),
                    r = null,
                    s = i.find("input[type='checkbox']");

                function l(e, t) {
                    if (o(e).prop("checked", !o(e).prop("checked")).trigger("change"), n || (n = e), n) {
                        if (t) {
                            var a = s.index(e),
                                i = s.index(n);
                            s.slice(Math.min(a, i), Math.max(a, i) + 1).prop("checked", n.checked).trigger("change")
                        }
                        n = e
                    }
                    if (r) {
                        var l = !1,
                            c = !0;
                        s.each(function() {
                            o(this).prop("checked") ? l = !0 : c = !1
                        }), l ? r.prop("indeterminate", l) : (r.prop("indeterminate", l), r.prop("checked", l)), c && (r.prop("indeterminate", !1), r.prop("checked", c))
                    }
                    document.activeElement.blur(), d()
                }

                function d() {
                    s.each(function() {
                        o(this).prop("checked") ? o(this).parents(".card").addClass("active") : o(this).parents(".card").removeClass("active")
                    })
                }
                i.data("checkAll") && (r = o("#" + i.data("checkAll"))).on("click", function() {
                    s.prop("checked", o(r).prop("checked")).trigger("change"), document.activeElement.blur(), d()
                }), i.on("click", t.items, function(e) {
                    o(e.target).is("a") || o(e.target).parent().is("a") || (o(e.target).is("input[type='checkbox']") && (e.preventDefault(), e.stopPropagation()), l(o(this).find("input[type='checkbox']")[0], e.shiftKey))
                }), a.selectAll = function() {
                    r && (s.prop("checked", !0).trigger("change"), r.prop("checked", !0), r.prop("indeterminate", !1), d())
                }, a.deSelectAll = function() {
                    r && (s.prop("checked", !1).trigger("change"), r.prop("checked", !1), r.prop("indeterminate", !1), d())
                }, a.rightClick = function(e) {
                    var t = o(e).find("input[type='checkbox']")[0];
                    o(t).prop("checked") || (a.deSelectAll(), l(t, !1))
                }
            }, o.fn.shiftSelectable = function(e) {
                return this.each(function() {
                    if (null == o(this).data("shiftSelectable")) {
                        var t = new o.shiftSelectable(this, e);
                        o(this).data("shiftSelectable", t)
                    }
                })
            }, o.dore = function(e, t) {
                var a = {},
                    n = this;
                n.settings = {};
                o(e), e = e;
                ! function() {
                    he = he || {}, n.settings = o.extend({}, a, he);
                    var e = getComputedStyle(document.body),
                        t = e.getPropertyValue("--theme-color-1").trim(),
                        i = e.getPropertyValue("--theme-color-2").trim(),
                        r = e.getPropertyValue("--theme-color-3").trim(),
                        s = e.getPropertyValue("--theme-color-4").trim(),
                        l = e.getPropertyValue("--theme-color-5").trim(),
                        d = (e.getPropertyValue("--theme-color-6").trim(), e.getPropertyValue("--theme-color-1-10").trim()),
                        c = e.getPropertyValue("--theme-color-2-10").trim(),
                        u = e.getPropertyValue("--theme-color-3-10").trim(),
                        p = e.getPropertyValue("--theme-color-4-10").trim(),
                        h = e.getPropertyValue("--theme-color-5-10").trim(),
                        m = (e.getPropertyValue("--theme-color-6-10").trim(), e.getPropertyValue("--primary-color").trim()),
                        g = e.getPropertyValue("--foreground-color").trim(),
                        b = e.getPropertyValue("--separator-color").trim(),
                        f = 1440,
                        C = 768,
                        y = 768;

                    function w() {
                        var e = o(window).outerHeight(),
                            t = o(window).outerWidth(),
                            a = o(".navbar").outerHeight(),
                            n = parseInt(o(".sub-menu .scroll").css("margin-top"), 10);
                        o(".sub-menu .scroll").css("height", e - a - 2 * n), o(".main-menu .scroll").css("height", e - a), o(".app-menu .scroll").css("height", e - a - 40), o(".chat-app .scroll").length > 0 && de && (o(".chat-app .scroll").scrollTop(o(".chat-app .scroll").prop("scrollHeight")), de.update()), t < y ? o("#app-container").addClass("menu-mobile") : t < f ? (o("#app-container").removeClass("menu-mobile"), o("#app-container").hasClass("menu-default") && (o("#app-container").removeClass(S), o("#app-container").addClass("menu-default menu-sub-hidden"))) : (o("#app-container").removeClass("menu-mobile"), o("#app-container").hasClass("menu-default") && o("#app-container").hasClass("menu-sub-hidden") && o("#app-container").removeClass("menu-sub-hidden")), B(0, !0)
                    }

                    function v() {
                        var e = o(".search input").val(),
                            t = o(".search").data("searchPath");
                        "" != e && (o(".search input").val(""), window.location.href = t + e)
                    }

                    function x() {
                        o(".search").hasClass("mobile-view") && (o(".search").removeClass("mobile-view"), o(".search input").val(""))
                    }
                    o(window).on("resize", function(e) {
                        e.originalEvent.isTrusted && w()
                    }), w(), o(".search .search-icon").on("click", function() {
                        o(window).outerWidth() < C ? o(".search").hasClass("mobile-view") ? (o(".search").removeClass("mobile-view"), v()) : (o(".search").addClass("mobile-view"), o(".search input").focus()) : v()
                    }), o(".search input").on("keyup", function(e) {
                        13 == e.which && v(), 27 == e.which && x()
                    }), o(document).on("click", function(e) {
                        o(e.target).parents().hasClass("search") || x()
                    }), o(".list").shiftSelectable();
                    var k = 0,
                        S = "menu-default menu-hidden sub-hidden main-hidden menu-sub-hidden main-show-temporary sub-show-temporary menu-mobile";

                    function B(e, t, a) {
                        k = e;
                        var n = o("#app-container");
                        if (0 != n.length) {
                            if (a = a || W(), 0 == o(".sub-menu ul[data-link='" + a + "']").length && (2 == k || t) && o(window).outerWidth() >= y && A("menu-default")) return t ? (o("#app-container").removeClass(S), o("#app-container").addClass("menu-default menu-sub-hidden sub-hidden"), k = 1) : (o("#app-container").removeClass(S), o("#app-container").addClass("menu-default main-hidden menu-sub-hidden sub-hidden"), k = 0), void P();
                            if (0 == o(".sub-menu ul[data-link='" + a + "']").length && (1 == k || t) && o(window).outerWidth() >= y && A("menu-sub-hidden")) return t ? (o("#app-container").removeClass(S), o("#app-container").addClass("menu-sub-hidden sub-hidden"), k = 0) : (o("#app-container").removeClass(S), o("#app-container").addClass("menu-sub-hidden main-hidden sub-hidden"), k = -1), void P();
                            if (0 == o(".sub-menu ul[data-link='" + a + "']").length && (1 == k || t) && o(window).outerWidth() >= y && A("menu-hidden")) return t ? (o("#app-container").removeClass(S), o("#app-container").addClass("menu-hidden main-hidden sub-hidden"), k = 0) : (o("#app-container").removeClass(S), o("#app-container").addClass("menu-hidden main-show-temporary"), k = 3), void P();
                            e % 4 == 0 ? (A("menu-default") && A("menu-sub-hidden") ? nextClasses = "menu-default menu-sub-hidden" : A("menu-default") ? nextClasses = "menu-default" : A("menu-sub-hidden") ? nextClasses = "menu-sub-hidden" : A("menu-hidden") && (nextClasses = "menu-hidden"), k = 0) : e % 4 == 1 ? A("menu-default") && A("menu-sub-hidden") ? nextClasses = "menu-default menu-sub-hidden main-hidden sub-hidden" : A("menu-default") ? nextClasses = "menu-default sub-hidden" : A("menu-sub-hidden") ? nextClasses = "menu-sub-hidden main-hidden sub-hidden" : A("menu-hidden") && (nextClasses = "menu-hidden main-show-temporary") : e % 4 == 2 ? A("menu-default") && A("menu-sub-hidden") ? nextClasses = "menu-default menu-sub-hidden sub-hidden" : A("menu-default") ? nextClasses = "menu-default main-hidden sub-hidden" : A("menu-sub-hidden") ? nextClasses = "menu-sub-hidden sub-hidden" : A("menu-hidden") && (nextClasses = "menu-hidden main-show-temporary sub-show-temporary") : e % 4 == 3 && (A("menu-default") && A("menu-sub-hidden") ? nextClasses = "menu-default menu-sub-hidden sub-show-temporary" : A("menu-default") ? nextClasses = "menu-default sub-hidden" : A("menu-sub-hidden") ? nextClasses = "menu-sub-hidden sub-show-temporary" : A("menu-hidden") && (nextClasses = "menu-hidden main-show-temporary")), A("menu-mobile") && (nextClasses += " menu-mobile"), n.removeClass(S), n.addClass(nextClasses), P()
                        }
                    }

                    function W() {
                        return o(".main-menu ul li.active a").attr("href").replace("#", "")
                    }

                    function A(e) {
                        return o("#app-container").attr("class").split(" ").filter(function(e) {
                            return "" != e
                        }).includes(e)
                    }
                    o(".menu-button").on("click", function(e) {
                        e.preventDefault(), B(++k)
                    }), o(".menu-button-mobile").on("click", function(e) {
                        return e.preventDefault(), o("#app-container").removeClass("sub-show-temporary").toggleClass("main-show-temporary"), !1
                    }), o(".main-menu").on("click", "a", function(e) {
                        e.preventDefault();
                        var t = o(this).attr("href").replace("#", "");
                        if (0 != o(".sub-menu ul[data-link='" + t + "']").length) return I(o(this).attr("href")), o("#app-container"), o("#app-container").hasClass("menu-mobile") ? o("#app-container").addClass("sub-show-temporary") : !o("#app-container").hasClass("menu-sub-hidden") || 2 != k && 0 != k ? !o("#app-container").hasClass("menu-hidden") || 1 != k && 3 != k ? !o("#app-container").hasClass("menu-default") || o("#app-container").hasClass("menu-sub-hidden") || 1 != k && 3 != k || B(0, !1, t) : B(2, !1, t) : B(3, !1, t), !1;
                        window.location.href = t
                    }), o(document).on("click", function(e) {
                        o(e.target).parents().hasClass("menu-button") || o(e.target).hasClass("menu-button") || o(e.target).parents().hasClass("sidebar") || o(e.target).hasClass("sidebar") || (o("#app-container").hasClass("menu-sub-hidden") && 3 == k ? B(W() == E ? 2 : 0) : (o("#app-container").hasClass("menu-hidden") || o("#app-container").hasClass("menu-mobile")) && B(0))
                    });
                    var E = "";

                    function I(e) {
                        if (0 != o(".main-menu").length) {
                            var t = e.replace("#", "");
                            if (0 == o(".sub-menu ul[data-link='" + t + "']").length) {
                                if (o("#app-container").removeClass("sub-show-temporary"), 0 == o("#app-container").length) return;
                                return k = A("menu-sub-hidden") || A("menu-hidden") ? 0 : 1, o("#app-container").addClass("sub-hidden"), o(".sub-menu").addClass("no-transition"), o("main").addClass("no-transition"), void setTimeout(function() {
                                    o(".sub-menu").removeClass("no-transition"), o("main").removeClass("no-transition")
                                }, 350)
                            }
                            t != E && (o(".sub-menu ul").fadeOut(0), o(".sub-menu ul[data-link='" + t + "']").slideDown(100), o(".sub-menu .scroll").scrollTop(0), E = t)
                        }
                    }

                    function P() {
                        setTimeout(function() {
                            var e = document.createEvent("HTMLEvents");
                            e.initEvent("resize", !1, !1), window.dispatchEvent(e)
                        }, 350)
                    }

                    function R(e) {
                        var t = o(e.parents(".question"));
                        t.toggleClass("edit-quesiton"), t.toggleClass("view-quesiton");
                        var a = t.find(".question-collapse");
                        a.hasClass("show") || (a.collapse("toggle"), t.find(".rotate-icon-click").toggleClass("rotate"))
                    }
                    if (I(o(".main-menu ul li.active a").attr("href")), o(".app-menu-button").on("click", function() {
                        event.preventDefault(), o(".app-menu").hasClass("shown") ? o(".app-menu").removeClass("shown") : o(".app-menu").addClass("shown")
                    }), o(document).on("click", function(e) {
                        o(e.target).parents().hasClass("app-menu") || o(e.target).parents().hasClass("app-menu-button") || o(e.target).hasClass("app-menu-button") || o(e.target).hasClass("app-menu") || o(".app-menu").hasClass("shown") && o(".app-menu").removeClass("shown")
                    }), o(document).on("click", ".question .view-button", function() {
                        R(o(this))
                    }), o(document).on("click", ".question .edit-button", function() {
                        R(o(this))
                    }), o(document).on("click", ".rotate-icon-click", function() {
                        o(this).toggleClass("rotate")
                    }), "undefined" != typeof Chart) {
                        Chart.defaults.global.defaultFontFamily = "'Nunito', sans-serif", Chart.defaults.LineWithShadow = Chart.defaults.line, Chart.controllers.LineWithShadow = Chart.controllers.line.extend({
                            draw: function(e) {
                                Chart.controllers.line.prototype.draw.call(this, e);
                                var t = this.chart.ctx;
                                t.save(), t.shadowColor = "rgba(0,0,0,0.15)", t.shadowBlur = 10, t.shadowOffsetX = 0, t.shadowOffsetY = 10, t.responsive = !0, t.stroke(), Chart.controllers.line.prototype.draw.apply(this, arguments), t.restore()
                            }
                        }), Chart.defaults.BarWithShadow = Chart.defaults.bar, Chart.controllers.BarWithShadow = Chart.controllers.bar.extend({
                            draw: function(e) {
                                Chart.controllers.bar.prototype.draw.call(this, e);
                                var t = this.chart.ctx;
                                t.save(), t.shadowColor = "rgba(0,0,0,0.15)", t.shadowBlur = 12, t.shadowOffsetX = 5, t.shadowOffsetY = 10, t.responsive = !0, Chart.controllers.bar.prototype.draw.apply(this, arguments), t.restore()
                            }
                        }), Chart.defaults.LineWithLine = Chart.defaults.line, Chart.controllers.LineWithLine = Chart.controllers.line.extend({
                            draw: function(e) {
                                if (Chart.controllers.line.prototype.draw.call(this, e), this.chart.tooltip._active && this.chart.tooltip._active.length) {
                                    var t = this.chart.tooltip._active[0],
                                        a = this.chart.ctx,
                                        o = t.tooltipPosition().x,
                                        n = this.chart.scales["y-axis-0"].top,
                                        i = this.chart.scales["y-axis-0"].bottom;
                                    a.save(), a.beginPath(), a.moveTo(o, n), a.lineTo(o, i), a.lineWidth = 1, a.strokeStyle = "rgba(0,0,0,0.1)", a.stroke(), a.restore()
                                }
                            }
                        }), Chart.defaults.DoughnutWithShadow = Chart.defaults.doughnut, Chart.controllers.DoughnutWithShadow = Chart.controllers.doughnut.extend({
                            draw: function(e) {
                                Chart.controllers.doughnut.prototype.draw.call(this, e);
                                var t = this.chart.chart.ctx;
                                t.save(), t.shadowColor = "rgba(0,0,0,0.15)", t.shadowBlur = 10, t.shadowOffsetX = 0, t.shadowOffsetY = 10, t.responsive = !0, Chart.controllers.doughnut.prototype.draw.apply(this, arguments), t.restore()
                            }
                        }), Chart.defaults.PieWithShadow = Chart.defaults.pie, Chart.controllers.PieWithShadow = Chart.controllers.pie.extend({
                            draw: function(e) {
                                Chart.controllers.pie.prototype.draw.call(this, e);
                                var t = this.chart.chart.ctx;
                                t.save(), t.shadowColor = "rgba(0,0,0,0.15)", t.shadowBlur = 10, t.shadowOffsetX = 0, t.shadowOffsetY = 10, t.responsive = !0, Chart.controllers.pie.prototype.draw.apply(this, arguments), t.restore()
                            }
                        }), Chart.defaults.ScatterWithShadow = Chart.defaults.scatter, Chart.controllers.ScatterWithShadow = Chart.controllers.scatter.extend({
                            draw: function(e) {
                                Chart.controllers.scatter.prototype.draw.call(this, e);
                                var t = this.chart.chart.ctx;
                                t.save(), t.shadowColor = "rgba(0,0,0,0.2)", t.shadowBlur = 7, t.shadowOffsetX = 0, t.shadowOffsetY = 7, t.responsive = !0, Chart.controllers.scatter.prototype.draw.apply(this, arguments), t.restore()
                            }
                        }), Chart.defaults.RadarWithShadow = Chart.defaults.radar, Chart.controllers.RadarWithShadow = Chart.controllers.radar.extend({
                            draw: function(e) {
                                Chart.controllers.radar.prototype.draw.call(this, e);
                                var t = this.chart.chart.ctx;
                                t.save(), t.shadowColor = "rgba(0,0,0,0.2)", t.shadowBlur = 7, t.shadowOffsetX = 0, t.shadowOffsetY = 7, t.responsive = !0, Chart.controllers.radar.prototype.draw.apply(this, arguments), t.restore()
                            }
                        }), Chart.defaults.PolarWithShadow = Chart.defaults.polarArea, Chart.controllers.PolarWithShadow = Chart.controllers.polarArea.extend({
                            draw: function(e) {
                                Chart.controllers.polarArea.prototype.draw.call(this, e);
                                var t = this.chart.chart.ctx;
                                t.save(), t.shadowColor = "rgba(0,0,0,0.2)", t.shadowBlur = 10, t.shadowOffsetX = 5, t.shadowOffsetY = 10, t.responsive = !0, Chart.controllers.polarArea.prototype.draw.apply(this, arguments), t.restore()
                            }
                        });
                        var T = {
                            backgroundColor: g,
                            titleFontColor: m,
                            borderColor: b,
                            borderWidth: .5,
                            bodyFontColor: m,
                            bodySpacing: 10,
                            xPadding: 15,
                            yPadding: 15,
                            cornerRadius: .15,
                            displayColors: !1
                        };
                        if (document.getElementById("visitChartFull")) {
                            var z = document.getElementById("visitChartFull").getContext("2d");
                            new Chart(z, {
                                type: "LineWithShadow",
                                data: {
                                    labels: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
                                    datasets: [{
                                        label: "Data",
                                        borderColor: t,
                                        pointBorderColor: t,
                                        pointBackgroundColor: t,
                                        pointHoverBackgroundColor: t,
                                        pointHoverBorderColor: t,
                                        pointRadius: 3,
                                        pointBorderWidth: 3,
                                        pointHoverRadius: 3,
                                        fill: !0,
                                        backgroundColor: d,
                                        borderWidth: 2,
                                        data: [180, 140, 150, 120, 180, 110, 160],
                                        datalabels: {
                                            align: "end",
                                            anchor: "end"
                                        }
                                    }]
                                },
                                options: {
                                    layout: {
                                        padding: {
                                            left: 0,
                                            right: 0,
                                            top: 40,
                                            bottom: 0
                                        }
                                    },
                                    plugins: {
                                        datalabels: {
                                            backgroundColor: "transparent",
                                            borderRadius: 30,
                                            borderWidth: 1,
                                            padding: 5,
                                            borderColor: function(e) {
                                                return e.dataset.borderColor
                                            },
                                            color: function(e) {
                                                return e.dataset.borderColor
                                            },
                                            font: {
                                                weight: "bold",
                                                size: 10
                                            },
                                            formatter: Math.round
                                        }
                                    },
                                    responsive: !0,
                                    maintainAspectRatio: !1,
                                    legend: {
                                        display: !1
                                    },
                                    tooltips: T,
                                    scales: {
                                        yAxes: [{
                                            ticks: {
                                                min: 0
                                            },
                                            display: !1
                                        }],
                                        xAxes: [{
                                            ticks: {
                                                min: 0
                                            },
                                            display: !1
                                        }]
                                    }
                                }
                            })
                        }
                        if (document.getElementById("visitChart")) {
                            var L = document.getElementById("visitChart").getContext("2d");
                            new Chart(L, {
                                type: "LineWithShadow",
                                options: {
                                    plugins: {
                                        datalabels: {
                                            display: !1
                                        }
                                    },
                                    responsive: !0,
                                    maintainAspectRatio: !1,
                                    scales: {
                                        yAxes: [{
                                            gridLines: {
                                                display: !0,
                                                lineWidth: 1,
                                                color: "rgba(0,0,0,0.1)",
                                                drawBorder: !1
                                            },
                                            ticks: {
                                                beginAtZero: !0,
                                                stepSize: 5,
                                                min: 50,
                                                max: 70,
                                                padding: 0
                                            }
                                        }],
                                        xAxes: [{
                                            gridLines: {
                                                display: !1
                                            }
                                        }]
                                    },
                                    legend: {
                                        display: !1
                                    },
                                    tooltips: T
                                },
                                data: {
                                    labels: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
                                    datasets: [{
                                        label: "",
                                        data: [54, 63, 60, 65, 60, 68, 60],
                                        borderColor: t,
                                        pointBackgroundColor: g,
                                        pointBorderColor: t,
                                        pointHoverBackgroundColor: t,
                                        pointHoverBorderColor: g,
                                        pointRadius: 4,
                                        pointBorderWidth: 2,
                                        pointHoverRadius: 5,
                                        fill: !0,
                                        borderWidth: 2,
                                        backgroundColor: d
                                    }]
                                }
                            })
                        }
                        if (document.getElementById("conversionChart")) {
                            var D = document.getElementById("conversionChart").getContext("2d");
                            new Chart(D, {
                                type: "LineWithShadow",
                                options: {
                                    plugins: {
                                        datalabels: {
                                            display: !1
                                        }
                                    },
                                    responsive: !0,
                                    maintainAspectRatio: !1,
                                    scales: {
                                        yAxes: [{
                                            gridLines: {
                                                display: !0,
                                                lineWidth: 1,
                                                color: "rgba(0,0,0,0.1)",
                                                drawBorder: !1
                                            },
                                            ticks: {
                                                beginAtZero: !0,
                                                stepSize: 5,
                                                min: 50,
                                                max: 70,
                                                padding: 0
                                            }
                                        }],
                                        xAxes: [{
                                            gridLines: {
                                                display: !1
                                            }
                                        }]
                                    },
                                    legend: {
                                        display: !1
                                    },
                                    tooltips: T
                                },
                                data: {
                                    labels: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
                                    datasets: [{
                                        label: "",
                                        data: [65, 60, 68, 54, 63, 60, 60],
                                        borderColor: i,
                                        pointBackgroundColor: g,
                                        pointBorderColor: i,
                                        pointHoverBackgroundColor: i,
                                        pointHoverBorderColor: g,
                                        pointRadius: 4,
                                        pointBorderWidth: 2,
                                        pointHoverRadius: 5,
                                        fill: !0,
                                        borderWidth: 2,
                                        backgroundColor: c
                                    }]
                                }
                            })
                        }
                        var F = {
                                layout: {
                                    padding: {
                                        left: 5,
                                        right: 5,
                                        top: 10,
                                        bottom: 10
                                    }
                                },
                                plugins: {
                                    datalabels: {
                                        display: !1
                                    }
                                },
                                responsive: !0,
                                maintainAspectRatio: !1,
                                legend: {
                                    display: !1
                                },
                                tooltips: {
                                    intersect: !1,
                                    enabled: !1,
                                    custom: function(e) {
                                        if (e && e.dataPoints) {
                                            var t = o(this._chart.canvas.offsetParent),
                                                a = e.dataPoints[0].yLabel,
                                                n = e.dataPoints[0].xLabel,
                                                i = e.body[0].lines[0].split(":")[0];
                                            t.find(".value").html("$" + o.fn.addCommas(a)), t.find(".label").html(i + "-" + n)
                                        }
                                    }
                                },
                                scales: {
                                    yAxes: [{
                                        ticks: {
                                            beginAtZero: !0
                                        },
                                        display: !1
                                    }],
                                    xAxes: [{
                                        display: !1
                                    }]
                                }
                            },
                            H = {
                                afterInit: function(e, t) {
                                    var a = o(e.canvas.offsetParent),
                                        n = e.data.datasets[0].data[0],
                                        i = e.data.labels[0],
                                        r = e.data.datasets[0].label;
                                    a.find(".value").html("$" + o.fn.addCommas(n)), a.find(".label").html(r + "-" + i)
                                }
                            };
                        if (document.getElementById("smallChart1")) {
                            var M = document.getElementById("smallChart1").getContext("2d");
                            new Chart(M, {
                                type: "LineWithLine",
                                plugins: [H],
                                data: {
                                    labels: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
                                    datasets: [{
                                        label: "Total Orders",
                                        borderColor: t,
                                        pointBorderColor: t,
                                        pointHoverBackgroundColor: t,
                                        pointHoverBorderColor: t,
                                        pointRadius: 2,
                                        pointBorderWidth: 3,
                                        pointHoverRadius: 2,
                                        fill: !1,
                                        borderWidth: 2,
                                        data: [1250, 1300, 1550, 921, 1810, 1106, 1610],
                                        datalabels: {
                                            align: "end",
                                            anchor: "end"
                                        }
                                    }]
                                },
                                options: F
                            })
                        }
                        if (document.getElementById("smallChart2") && (M = document.getElementById("smallChart2").getContext("2d"), new Chart(M, {
                            type: "LineWithLine",
                            plugins: [H],
                            data: {
                                labels: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
                                datasets: [{
                                    label: "Pending Orders",
                                    borderColor: t,
                                    pointBorderColor: t,
                                    pointHoverBackgroundColor: t,
                                    pointHoverBorderColor: t,
                                    pointRadius: 2,
                                    pointBorderWidth: 3,
                                    pointHoverRadius: 2,
                                    fill: !1,
                                    borderWidth: 2,
                                    data: [115, 120, 300, 222, 105, 85, 36],
                                    datalabels: {
                                        align: "end",
                                        anchor: "end"
                                    }
                                }]
                            },
                            options: F
                        })), document.getElementById("smallChart3") && (M = document.getElementById("smallChart3").getContext("2d"), new Chart(M, {
                            type: "LineWithLine",
                            plugins: [H],
                            data: {
                                labels: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
                                datasets: [{
                                    label: "Active Orders",
                                    borderColor: t,
                                    pointBorderColor: t,
                                    pointHoverBackgroundColor: t,
                                    pointHoverBorderColor: t,
                                    pointRadius: 2,
                                    pointBorderWidth: 3,
                                    pointHoverRadius: 2,
                                    fill: !1,
                                    borderWidth: 2,
                                    data: [350, 452, 762, 952, 630, 85, 158],
                                    datalabels: {
                                        align: "end",
                                        anchor: "end"
                                    }
                                }]
                            },
                            options: F
                        })), document.getElementById("smallChart4") && (M = document.getElementById("smallChart4").getContext("2d"), new Chart(M, {
                            type: "LineWithLine",
                            plugins: [H],
                            data: {
                                labels: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
                                datasets: [{
                                    label: "Shipped Orders",
                                    borderColor: t,
                                    pointBorderColor: t,
                                    pointHoverBackgroundColor: t,
                                    pointHoverBorderColor: t,
                                    pointRadius: 2,
                                    pointBorderWidth: 3,
                                    pointHoverRadius: 2,
                                    fill: !1,
                                    borderWidth: 2,
                                    data: [200, 452, 250, 630, 125, 85, 20],
                                    datalabels: {
                                        align: "end",
                                        anchor: "end"
                                    }
                                }]
                            },
                            options: F
                        })), document.getElementById("salesChart")) {
                            var N = document.getElementById("salesChart").getContext("2d");
                            new Chart(N, {
                                type: "LineWithShadow",
                                options: {
                                    plugins: {
                                        datalabels: {
                                            display: !1
                                        }
                                    },
                                    responsive: !0,
                                    maintainAspectRatio: !1,
                                    scales: {
                                        yAxes: [{
                                            gridLines: {
                                                display: !0,
                                                lineWidth: 1,
                                                color: "rgba(0,0,0,0.1)",
                                                drawBorder: !1
                                            },
                                            ticks: {
                                                beginAtZero: !0,
                                                stepSize: 5,
                                                min: 50,
                                                max: 70,
                                                padding: 20
                                            }
                                        }],
                                        xAxes: [{
                                            gridLines: {
                                                display: !1
                                            }
                                        }]
                                    },
                                    legend: {
                                        display: !1
                                    },
                                    tooltips: T
                                },
                                data: {
                                    labels: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
                                    datasets: [{
                                        label: "",
                                        data: [54, 63, 60, 65, 60, 68, 60],
                                        borderColor: t,
                                        pointBackgroundColor: g,
                                        pointBorderColor: t,
                                        pointHoverBackgroundColor: t,
                                        pointHoverBorderColor: g,
                                        pointRadius: 6,
                                        pointBorderWidth: 2,
                                        pointHoverRadius: 8,
                                        fill: !1
                                    }]
                                }
                            })
                        }
                        if (document.getElementById("areaChart")) {
                            var O = document.getElementById("areaChart").getContext("2d");
                            new Chart(O, {
                                type: "LineWithShadow",
                                options: {
                                    plugins: {
                                        datalabels: {
                                            display: !1
                                        }
                                    },
                                    responsive: !0,
                                    maintainAspectRatio: !1,
                                    scales: {
                                        yAxes: [{
                                            gridLines: {
                                                display: !0,
                                                lineWidth: 1,
                                                color: "rgba(0,0,0,0.1)",
                                                drawBorder: !1
                                            },
                                            ticks: {
                                                beginAtZero: !0,
                                                stepSize: 5,
                                                min: 50,
                                                max: 70,
                                                padding: 0
                                            }
                                        }],
                                        xAxes: [{
                                            gridLines: {
                                                display: !1
                                            }
                                        }]
                                    },
                                    legend: {
                                        display: !1
                                    },
                                    tooltips: T
                                },
                                data: {
                                    labels: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
                                    datasets: [{
                                        label: "",
                                        data: [54, 63, 60, 65, 60, 68, 60],
                                        borderColor: t,
                                        pointBackgroundColor: g,
                                        pointBorderColor: t,
                                        pointHoverBackgroundColor: t,
                                        pointHoverBorderColor: g,
                                        pointRadius: 4,
                                        pointBorderWidth: 2,
                                        pointHoverRadius: 5,
                                        fill: !0,
                                        borderWidth: 2,
                                        backgroundColor: d
                                    }]
                                }
                            })
                        }
                        if (document.getElementById("areaChartNoShadow")) {
                            var q = document.getElementById("areaChartNoShadow").getContext("2d");
                            new Chart(q, {
                                type: "line",
                                options: {
                                    plugins: {
                                        datalabels: {
                                            display: !1
                                        }
                                    },
                                    responsive: !0,
                                    maintainAspectRatio: !1,
                                    scales: {
                                        yAxes: [{
                                            gridLines: {
                                                display: !0,
                                                lineWidth: 1,
                                                color: "rgba(0,0,0,0.1)",
                                                drawBorder: !1
                                            },
                                            ticks: {
                                                beginAtZero: !0,
                                                stepSize: 5,
                                                min: 50,
                                                max: 70,
                                                padding: 0
                                            }
                                        }],
                                        xAxes: [{
                                            gridLines: {
                                                display: !1
                                            }
                                        }]
                                    },
                                    legend: {
                                        display: !1
                                    },
                                    tooltips: T
                                },
                                data: {
                                    labels: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
                                    datasets: [{
                                        label: "",
                                        data: [54, 63, 60, 65, 60, 68, 60],
                                        borderColor: t,
                                        pointBackgroundColor: g,
                                        pointBorderColor: t,
                                        pointHoverBackgroundColor: t,
                                        pointHoverBorderColor: g,
                                        pointRadius: 4,
                                        pointBorderWidth: 2,
                                        pointHoverRadius: 5,
                                        fill: !0,
                                        borderWidth: 2,
                                        backgroundColor: d
                                    }]
                                }
                            })
                        }
                        if (document.getElementById("scatterChart")) {
                            var _ = document.getElementById("scatterChart").getContext("2d");
                            new Chart(_, {
                                type: "ScatterWithShadow",
                                options: {
                                    plugins: {
                                        datalabels: {
                                            display: !1
                                        }
                                    },
                                    responsive: !0,
                                    maintainAspectRatio: !1,
                                    scales: {
                                        yAxes: [{
                                            gridLines: {
                                                display: !0,
                                                lineWidth: 1,
                                                color: "rgba(0,0,0,0.1)",
                                                drawBorder: !1
                                            },
                                            ticks: {
                                                beginAtZero: !0,
                                                stepSize: 20,
                                                min: -80,
                                                max: 80,
                                                padding: 20
                                            }
                                        }],
                                        xAxes: [{
                                            gridLines: {
                                                display: !0,
                                                lineWidth: 1,
                                                color: "rgba(0,0,0,0.1)"
                                            }
                                        }]
                                    },
                                    legend: {
                                        position: "bottom",
                                        labels: {
                                            padding: 30,
                                            usePointStyle: !0,
                                            fontSize: 12
                                        }
                                    },
                                    tooltips: T
                                },
                                data: {
                                    datasets: [{
                                        borderWidth: 2,
                                        label: "Cakes",
                                        borderColor: t,
                                        backgroundColor: d,
                                        data: [{
                                            x: 62,
                                            y: -78
                                        }, {
                                            x: -0,
                                            y: 74
                                        }, {
                                            x: -67,
                                            y: 45
                                        }, {
                                            x: -26,
                                            y: -43
                                        }, {
                                            x: -15,
                                            y: -30
                                        }, {
                                            x: 65,
                                            y: -68
                                        }, {
                                            x: -28,
                                            y: -61
                                        }]
                                    }, {
                                        borderWidth: 2,
                                        label: "Desserts",
                                        borderColor: i,
                                        backgroundColor: c,
                                        data: [{
                                            x: 79,
                                            y: 62
                                        }, {
                                            x: 62,
                                            y: 0
                                        }, {
                                            x: -76,
                                            y: -81
                                        }, {
                                            x: -51,
                                            y: 41
                                        }, {
                                            x: -9,
                                            y: 9
                                        }, {
                                            x: 72,
                                            y: -37
                                        }, {
                                            x: 62,
                                            y: -26
                                        }]
                                    }]
                                }
                            })
                        }
                        if (document.getElementById("scatterChartNoShadow")) {
                            var V = document.getElementById("scatterChartNoShadow").getContext("2d");
                            new Chart(V, {
                                type: "scatter",
                                options: {
                                    plugins: {
                                        datalabels: {
                                            display: !1
                                        }
                                    },
                                    responsive: !0,
                                    maintainAspectRatio: !1,
                                    scales: {
                                        yAxes: [{
                                            gridLines: {
                                                display: !0,
                                                lineWidth: 1,
                                                color: "rgba(0,0,0,0.1)",
                                                drawBorder: !1
                                            },
                                            ticks: {
                                                beginAtZero: !0,
                                                stepSize: 20,
                                                min: -80,
                                                max: 80,
                                                padding: 20
                                            }
                                        }],
                                        xAxes: [{
                                            gridLines: {
                                                display: !0,
                                                lineWidth: 1,
                                                color: "rgba(0,0,0,0.1)"
                                            }
                                        }]
                                    },
                                    legend: {
                                        position: "bottom",
                                        labels: {
                                            padding: 30,
                                            usePointStyle: !0,
                                            fontSize: 12
                                        }
                                    },
                                    tooltips: T
                                },
                                data: {
                                    datasets: [{
                                        borderWidth: 2,
                                        label: "Cakes",
                                        borderColor: t,
                                        backgroundColor: d,
                                        data: [{
                                            x: 62,
                                            y: -78
                                        }, {
                                            x: -0,
                                            y: 74
                                        }, {
                                            x: -67,
                                            y: 45
                                        }, {
                                            x: -26,
                                            y: -43
                                        }, {
                                            x: -15,
                                            y: -30
                                        }, {
                                            x: 65,
                                            y: -68
                                        }, {
                                            x: -28,
                                            y: -61
                                        }]
                                    }, {
                                        borderWidth: 2,
                                        label: "Desserts",
                                        borderColor: i,
                                        backgroundColor: c,
                                        data: [{
                                            x: 79,
                                            y: 62
                                        }, {
                                            x: 62,
                                            y: 0
                                        }, {
                                            x: -76,
                                            y: -81
                                        }, {
                                            x: -51,
                                            y: 41
                                        }, {
                                            x: -9,
                                            y: 9
                                        }, {
                                            x: 72,
                                            y: -37
                                        }, {
                                            x: 62,
                                            y: -26
                                        }]
                                    }]
                                }
                            })
                        }
                        if (document.getElementById("radarChartNoShadow")) {
                            var Z = document.getElementById("radarChartNoShadow").getContext("2d");
                            new Chart(Z, {
                                type: "radar",
                                options: {
                                    plugins: {
                                        datalabels: {
                                            display: !1
                                        }
                                    },
                                    responsive: !0,
                                    maintainAspectRatio: !1,
                                    scale: {
                                        ticks: {
                                            display: !1
                                        }
                                    },
                                    legend: {
                                        position: "bottom",
                                        labels: {
                                            padding: 30,
                                            usePointStyle: !0,
                                            fontSize: 12
                                        }
                                    },
                                    tooltips: T
                                },
                                data: {
                                    datasets: [{
                                        label: "Stock",
                                        borderWidth: 2,
                                        pointBackgroundColor: t,
                                        borderColor: t,
                                        backgroundColor: d,
                                        data: [80, 90, 70]
                                    }, {
                                        label: "Order",
                                        borderWidth: 2,
                                        pointBackgroundColor: i,
                                        borderColor: i,
                                        backgroundColor: c,
                                        data: [68, 80, 95]
                                    }],
                                    labels: ["Cakes", "Desserts", "Cupcakes"]
                                }
                            })
                        }
                        if (document.getElementById("radarChart")) {
                            var J = document.getElementById("radarChart").getContext("2d");
                            new Chart(J, {
                                type: "RadarWithShadow",
                                options: {
                                    plugins: {
                                        datalabels: {
                                            display: !1
                                        }
                                    },
                                    responsive: !0,
                                    maintainAspectRatio: !1,
                                    scale: {
                                        ticks: {
                                            display: !1
                                        }
                                    },
                                    legend: {
                                        position: "bottom",
                                        labels: {
                                            padding: 30,
                                            usePointStyle: !0,
                                            fontSize: 12
                                        }
                                    },
                                    tooltips: T
                                },
                                data: {
                                    datasets: [{
                                        label: "Stock",
                                        borderWidth: 2,
                                        pointBackgroundColor: t,
                                        borderColor: t,
                                        backgroundColor: d,
                                        data: [80, 90, 70]
                                    }, {
                                        label: "Order",
                                        borderWidth: 2,
                                        pointBackgroundColor: i,
                                        borderColor: i,
                                        backgroundColor: c,
                                        data: [68, 80, 95]
                                    }],
                                    labels: ["Cakes", "Desserts", "Cupcakes"]
                                }
                            })
                        }
                        if (document.getElementById("polarChart")) {
                            var U = document.getElementById("polarChart").getContext("2d");
                            new Chart(U, {
                                type: "PolarWithShadow",
                                options: {
                                    plugins: {
                                        datalabels: {
                                            display: !1
                                        }
                                    },
                                    responsive: !0,
                                    maintainAspectRatio: !1,
                                    scale: {
                                        ticks: {
                                            display: !1
                                        }
                                    },
                                    legend: {
                                        position: "bottom",
                                        labels: {
                                            padding: 30,
                                            usePointStyle: !0,
                                            fontSize: 12
                                        }
                                    },
                                    tooltips: T
                                },
                                data: {
                                    datasets: [{
                                        label: "Stock",
                                        borderWidth: 2,
                                        pointBackgroundColor: t,
                                        borderColor: [t, i, r],
                                        backgroundColor: [d, c, u],
                                        data: [80, 90, 70]
                                    }],
                                    labels: ["Cakes", "Desserts", "Cupcakes"]
                                }
                            })
                        }
                        if (document.getElementById("polarChartNoShadow")) {
                            var Y = document.getElementById("polarChartNoShadow").getContext("2d");
                            new Chart(Y, {
                                type: "polarArea",
                                options: {
                                    plugins: {
                                        datalabels: {
                                            display: !1
                                        }
                                    },
                                    responsive: !0,
                                    maintainAspectRatio: !1,
                                    scale: {
                                        ticks: {
                                            display: !1
                                        }
                                    },
                                    legend: {
                                        position: "bottom",
                                        labels: {
                                            padding: 30,
                                            usePointStyle: !0,
                                            fontSize: 12
                                        }
                                    },
                                    tooltips: T
                                },
                                data: {
                                    datasets: [{
                                        label: "Stock",
                                        borderWidth: 2,
                                        pointBackgroundColor: t,
                                        borderColor: [t, i, r],
                                        backgroundColor: [d, c, u],
                                        data: [80, 90, 70]
                                    }],
                                    labels: ["Cakes", "Desserts", "Cupcakes"]
                                }
                            })
                        }
                        if (document.getElementById("salesChartNoShadow")) {
                            var $ = document.getElementById("salesChartNoShadow").getContext("2d");
                            new Chart($, {
                                type: "line",
                                options: {
                                    plugins: {
                                        datalabels: {
                                            display: !1
                                        }
                                    },
                                    responsive: !0,
                                    maintainAspectRatio: !1,
                                    scales: {
                                        yAxes: [{
                                            gridLines: {
                                                display: !0,
                                                lineWidth: 1,
                                                color: "rgba(0,0,0,0.1)",
                                                drawBorder: !1
                                            },
                                            ticks: {
                                                beginAtZero: !0,
                                                stepSize: 5,
                                                min: 50,
                                                max: 70,
                                                padding: 20
                                            }
                                        }],
                                        xAxes: [{
                                            gridLines: {
                                                display: !1
                                            }
                                        }]
                                    },
                                    legend: {
                                        display: !1
                                    },
                                    tooltips: T
                                },
                                data: {
                                    labels: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
                                    datasets: [{
                                        label: "",
                                        data: [54, 63, 60, 65, 60, 68, 60],
                                        borderColor: t,
                                        pointBackgroundColor: g,
                                        pointBorderColor: t,
                                        pointHoverBackgroundColor: t,
                                        pointHoverBorderColor: g,
                                        pointRadius: 6,
                                        pointBorderWidth: 2,
                                        pointHoverRadius: 8,
                                        fill: !1
                                    }]
                                }
                            })
                        }
                        if (document.getElementById("productChart")) {
                            var X = document.getElementById("productChart").getContext("2d");
                            new Chart(X, {
                                type: "BarWithShadow",
                                options: {
                                    plugins: {
                                        datalabels: {
                                            display: !1
                                        }
                                    },
                                    responsive: !0,
                                    maintainAspectRatio: !1,
                                    scales: {
                                        yAxes: [{
                                            gridLines: {
                                                display: !0,
                                                lineWidth: 1,
                                                color: "rgba(0,0,0,0.1)",
                                                drawBorder: !1
                                            },
                                            ticks: {
                                                beginAtZero: !0,
                                                stepSize: 100,
                                                min: 300,
                                                max: 800,
                                                padding: 20
                                            }
                                        }],
                                        xAxes: [{
                                            gridLines: {
                                                display: !1
                                            }
                                        }]
                                    },
                                    legend: {
                                        position: "bottom",
                                        labels: {
                                            padding: 30,
                                            usePointStyle: !0,
                                            fontSize: 12
                                        }
                                    },
                                    tooltips: T
                                },
                                data: {
                                    labels: ["January", "February", "March", "April", "May", "June"],
                                    datasets: [{
                                        label: "Cakes",
                                        borderColor: t,
                                        backgroundColor: d,
                                        data: [456, 479, 324, 569, 702, 600],
                                        borderWidth: 2
                                    }, {
                                        label: "Desserts",
                                        borderColor: i,
                                        backgroundColor: c,
                                        data: [364, 504, 605, 400, 345, 320],
                                        borderWidth: 2
                                    }]
                                }
                            })
                        }
                        if (document.getElementById("productChartNoShadow")) {
                            var j = document.getElementById("productChartNoShadow").getContext("2d");
                            new Chart(j, {
                                type: "bar",
                                options: {
                                    plugins: {
                                        datalabels: {
                                            display: !1
                                        }
                                    },
                                    responsive: !0,
                                    maintainAspectRatio: !1,
                                    scales: {
                                        yAxes: [{
                                            gridLines: {
                                                display: !0,
                                                lineWidth: 1,
                                                color: "rgba(0,0,0,0.1)",
                                                drawBorder: !1
                                            },
                                            ticks: {
                                                beginAtZero: !0,
                                                stepSize: 100,
                                                min: 300,
                                                max: 800,
                                                padding: 20
                                            }
                                        }],
                                        xAxes: [{
                                            gridLines: {
                                                display: !1
                                            }
                                        }]
                                    },
                                    legend: {
                                        position: "bottom",
                                        labels: {
                                            padding: 30,
                                            usePointStyle: !0,
                                            fontSize: 12
                                        }
                                    },
                                    tooltips: T
                                },
                                data: {
                                    labels: ["January", "February", "March", "April", "May", "June"],
                                    datasets: [{
                                        label: "Cakes",
                                        borderColor: t,
                                        backgroundColor: d,
                                        data: [456, 479, 324, 569, 702, 600],
                                        borderWidth: 2
                                    }, {
                                        label: "Desserts",
                                        borderColor: i,
                                        backgroundColor: c,
                                        data: [364, 504, 605, 400, 345, 320],
                                        borderWidth: 2
                                    }]
                                }
                            })
                        }
                        var K = {
                            type: "LineWithShadow",
                            options: {
                                plugins: {
                                    datalabels: {
                                        display: !1
                                    }
                                },
                                responsive: !0,
                                maintainAspectRatio: !1,
                                scales: {
                                    yAxes: [{
                                        gridLines: {
                                            display: !0,
                                            lineWidth: 1,
                                            color: "rgba(0,0,0,0.1)",
                                            drawBorder: !1
                                        },
                                        ticks: {
                                            beginAtZero: !0,
                                            stepSize: 5,
                                            min: 50,
                                            max: 70,
                                            padding: 20
                                        }
                                    }],
                                    xAxes: [{
                                        gridLines: {
                                            display: !1
                                        }
                                    }]
                                },
                                legend: {
                                    display: !1
                                },
                                tooltips: T
                            },
                            data: {
                                labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                                datasets: [{
                                    borderWidth: 2,
                                    label: "",
                                    data: [54, 63, 60, 65, 60, 68, 60, 63, 60, 65, 60, 68],
                                    borderColor: t,
                                    pointBackgroundColor: g,
                                    pointBorderColor: t,
                                    pointHoverBackgroundColor: t,
                                    pointHoverBorderColor: g,
                                    pointRadius: 4,
                                    pointBorderWidth: 2,
                                    pointHoverRadius: 5,
                                    fill: !1
                                }]
                            }
                        };
                        document.getElementById("contributionChart1") && new Chart(document.getElementById("contributionChart1").getContext("2d"), K), document.getElementById("contributionChart2") && new Chart(document.getElementById("contributionChart2").getContext("2d"), K), document.getElementById("contributionChart3") && new Chart(document.getElementById("contributionChart3").getContext("2d"), K);
                        var Q = {
                            afterDatasetsUpdate: function(e) {},
                            beforeDraw: function(e) {
                                var t = e.chartArea.right,
                                    a = e.chartArea.bottom,
                                    o = e.chart.ctx;
                                o.restore();
                                var n = e.data.labels[0],
                                    i = e.data.datasets[0].data[0],
                                    r = e.data.datasets[0],
                                    s = r._meta[Object.keys(r._meta)[0]],
                                    l = s.total,
                                    d = parseFloat((i / l * 100).toFixed(1));
                                d = e.legend.legendItems[0].hidden ? 0 : d, e.pointAvailable && (n = e.data.labels[e.pointIndex], i = e.data.datasets[e.pointDataIndex].data[e.pointIndex], l = (s = (r = e.data.datasets[e.pointDataIndex])._meta[Object.keys(r._meta)[0]]).total, d = parseFloat((i / l * 100).toFixed(1)), d = e.legend.legendItems[e.pointIndex].hidden ? 0 : d), o.font = "36px Nunito, sans-serif", o.fillStyle = m, o.textBaseline = "middle";
                                var c = d + "%",
                                    u = Math.round((t - o.measureText(c).width) / 2),
                                    p = a / 2;
                                o.fillText(c, u, p), o.font = "14px Nunito, sans-serif", o.textBaseline = "middle";
                                var h = n;
                                u = Math.round((t - o.measureText(h).width) / 2), p = a / 2 - 30, o.fillText(h, u, p), o.save()
                            },
                            beforeEvent: function(e, t, a) {
                                var o = e.getElementAtEvent(t)[0];
                                o && (e.pointIndex = o._index, e.pointDataIndex = o._datasetIndex, e.pointAvailable = !0)
                            }
                        };
                        if (document.getElementById("categoryChart")) {
                            var G = document.getElementById("categoryChart");
                            new Chart(G, {
                                plugins: [Q],
                                type: "DoughnutWithShadow",
                                data: {
                                    labels: ["Cakes", "Cupcakes", "Desserts"],
                                    datasets: [{
                                        label: "",
                                        borderColor: [r, i, t],
                                        backgroundColor: [u, c, d],
                                        borderWidth: 2,
                                        data: [15, 25, 20]
                                    }]
                                },
                                draw: function() {},
                                options: {
                                    plugins: {
                                        datalabels: {
                                            display: !1
                                        }
                                    },
                                    responsive: !0,
                                    maintainAspectRatio: !1,
                                    cutoutPercentage: 80,
                                    title: {
                                        display: !1
                                    },
                                    layout: {
                                        padding: {
                                            bottom: 20
                                        }
                                    },
                                    legend: {
                                        position: "bottom",
                                        labels: {
                                            padding: 30,
                                            usePointStyle: !0,
                                            fontSize: 12
                                        }
                                    },
                                    tooltips: T
                                }
                            })
                        }
                        if (document.getElementById("categoryChartNoShadow")) {
                            var ee = document.getElementById("categoryChartNoShadow");
                            new Chart(ee, {
                                plugins: [Q],
                                type: "doughnut",
                                data: {
                                    labels: ["Cakes", "Cupcakes", "Desserts"],
                                    datasets: [{
                                        label: "",
                                        borderColor: [r, i, t],
                                        backgroundColor: [u, c, d],
                                        borderWidth: 2,
                                        data: [15, 25, 20]
                                    }]
                                },
                                draw: function() {},
                                options: {
                                    plugins: {
                                        datalabels: {
                                            display: !1
                                        }
                                    },
                                    responsive: !0,
                                    maintainAspectRatio: !1,
                                    cutoutPercentage: 80,
                                    title: {
                                        display: !1
                                    },
                                    layout: {
                                        padding: {
                                            bottom: 20
                                        }
                                    },
                                    legend: {
                                        position: "bottom",
                                        labels: {
                                            padding: 30,
                                            usePointStyle: !0,
                                            fontSize: 12
                                        }
                                    },
                                    tooltips: T
                                }
                            })
                        }
                        if (document.getElementById("pieChartNoShadow")) {
                            var te = document.getElementById("pieChartNoShadow");
                            new Chart(te, {
                                type: "pie",
                                data: {
                                    labels: ["Cakes", "Cupcakes", "Desserts"],
                                    datasets: [{
                                        label: "",
                                        borderColor: [t, i, r],
                                        backgroundColor: [d, c, u],
                                        borderWidth: 2,
                                        data: [15, 25, 20]
                                    }]
                                },
                                draw: function() {},
                                options: {
                                    plugins: {
                                        datalabels: {
                                            display: !1
                                        }
                                    },
                                    responsive: !0,
                                    maintainAspectRatio: !1,
                                    title: {
                                        display: !1
                                    },
                                    layout: {
                                        padding: {
                                            bottom: 20
                                        }
                                    },
                                    legend: {
                                        position: "bottom",
                                        labels: {
                                            padding: 30,
                                            usePointStyle: !0,
                                            fontSize: 12
                                        }
                                    },
                                    tooltips: T
                                }
                            })
                        }
                        if (document.getElementById("pieChart") && (te = document.getElementById("pieChart"), new Chart(te, {
                            type: "PieWithShadow",
                            data: {
                                labels: ["Cakes", "Cupcakes", "Desserts"],
                                datasets: [{
                                    label: "",
                                    borderColor: [t, i, r],
                                    backgroundColor: [d, c, u],
                                    borderWidth: 2,
                                    data: [15, 25, 20]
                                }]
                            },
                            draw: function() {},
                            options: {
                                plugins: {
                                    datalabels: {
                                        display: !1
                                    }
                                },
                                responsive: !0,
                                maintainAspectRatio: !1,
                                title: {
                                    display: !1
                                },
                                layout: {
                                    padding: {
                                        bottom: 20
                                    }
                                },
                                legend: {
                                    position: "bottom",
                                    labels: {
                                        padding: 30,
                                        usePointStyle: !0,
                                        fontSize: 12
                                    }
                                },
                                tooltips: T
                            }
                        })), document.getElementById("frequencyChart")) {
                            var ae = document.getElementById("frequencyChart");
                            new Chart(ae, {
                                plugins: [Q],
                                type: "DoughnutWithShadow",
                                data: {
                                    labels: ["Adding", "Editing", "Deleting"],
                                    datasets: [{
                                        label: "",
                                        borderColor: [t, i, r],
                                        backgroundColor: [d, c, u],
                                        borderWidth: 2,
                                        data: [15, 25, 20]
                                    }]
                                },
                                draw: function() {},
                                options: {
                                    plugins: {
                                        datalabels: {
                                            display: !1
                                        }
                                    },
                                    responsive: !0,
                                    maintainAspectRatio: !1,
                                    cutoutPercentage: 80,
                                    title: {
                                        display: !1
                                    },
                                    layout: {
                                        padding: {
                                            bottom: 20
                                        }
                                    },
                                    legend: {
                                        position: "bottom",
                                        labels: {
                                            padding: 30,
                                            usePointStyle: !0,
                                            fontSize: 12
                                        }
                                    },
                                    tooltips: T
                                }
                            })
                        }
                        if (document.getElementById("ageChart")) {
                            var oe = document.getElementById("ageChart");
                            new Chart(oe, {
                                plugins: [Q],
                                type: "DoughnutWithShadow",
                                data: {
                                    labels: ["12-24", "24-30", "30-40", "40-50", "50-60"],
                                    datasets: [{
                                        label: "",
                                        borderColor: [t, i, r, s, l],
                                        backgroundColor: [d, c, u, p, h],
                                        borderWidth: 2,
                                        data: [15, 25, 20, 30, 14]
                                    }]
                                },
                                draw: function() {},
                                options: {
                                    plugins: {
                                        datalabels: {
                                            display: !1
                                        }
                                    },
                                    responsive: !0,
                                    maintainAspectRatio: !1,
                                    cutoutPercentage: 80,
                                    title: {
                                        display: !1
                                    },
                                    layout: {
                                        padding: {
                                            bottom: 20
                                        }
                                    },
                                    legend: {
                                        position: "bottom",
                                        labels: {
                                            padding: 30,
                                            usePointStyle: !0,
                                            fontSize: 12
                                        }
                                    },
                                    tooltips: T
                                }
                            })
                        }
                        if (document.getElementById("genderChart")) {
                            var ne = document.getElementById("genderChart");
                            new Chart(ne, {
                                plugins: [Q],
                                type: "DoughnutWithShadow",
                                data: {
                                    labels: ["Male", "Female", "Other"],
                                    datasets: [{
                                        label: "",
                                        borderColor: [t, i, r],
                                        backgroundColor: [d, c, u],
                                        borderWidth: 2,
                                        data: [85, 45, 20]
                                    }]
                                },
                                draw: function() {},
                                options: {
                                    plugins: {
                                        datalabels: {
                                            display: !1
                                        }
                                    },
                                    responsive: !0,
                                    maintainAspectRatio: !1,
                                    cutoutPercentage: 80,
                                    title: {
                                        display: !1
                                    },
                                    layout: {
                                        padding: {
                                            bottom: 20
                                        }
                                    },
                                    legend: {
                                        position: "bottom",
                                        labels: {
                                            padding: 30,
                                            usePointStyle: !0,
                                            fontSize: 12
                                        }
                                    },
                                    tooltips: T
                                }
                            })
                        }
                        if (document.getElementById("workChart")) {
                            var ie = document.getElementById("workChart");
                            new Chart(ie, {
                                plugins: [Q],
                                type: "DoughnutWithShadow",
                                data: {
                                    labels: ["Employed for wages", "Self-employed", "Looking for work", "Retired"],
                                    datasets: [{
                                        label: "",
                                        borderColor: [t, i, r, s],
                                        backgroundColor: [d, c, u, p],
                                        borderWidth: 2,
                                        data: [15, 25, 20, 8]
                                    }]
                                },
                                draw: function() {},
                                options: {
                                    plugins: {
                                        datalabels: {
                                            display: !1
                                        }
                                    },
                                    responsive: !0,
                                    maintainAspectRatio: !1,
                                    cutoutPercentage: 80,
                                    title: {
                                        display: !1
                                    },
                                    layout: {
                                        padding: {
                                            bottom: 20
                                        }
                                    },
                                    legend: {
                                        position: "bottom",
                                        labels: {
                                            padding: 30,
                                            usePointStyle: !0,
                                            fontSize: 12
                                        }
                                    },
                                    tooltips: T
                                }
                            })
                        }
                        if (document.getElementById("codingChart")) {
                            var re = document.getElementById("codingChart");
                            new Chart(re, {
                                plugins: [Q],
                                type: "DoughnutWithShadow",
                                data: {
                                    labels: ["Python", "JavaScript", "PHP", "Java", "C#"],
                                    datasets: [{
                                        label: "",
                                        borderColor: [t, i, r, s, l],
                                        backgroundColor: [d, c, u, p, h],
                                        borderWidth: 2,
                                        data: [15, 25, 20, 8, 25]
                                    }]
                                },
                                draw: function() {},
                                options: {
                                    plugins: {
                                        datalabels: {
                                            display: !1
                                        }
                                    },
                                    responsive: !0,
                                    maintainAspectRatio: !1,
                                    cutoutPercentage: 80,
                                    title: {
                                        display: !1
                                    },
                                    layout: {
                                        padding: {
                                            bottom: 20
                                        }
                                    },
                                    legend: {
                                        position: "bottom",
                                        labels: {
                                            padding: 30,
                                            usePointStyle: !0,
                                            fontSize: 12
                                        }
                                    },
                                    tooltips: T
                                }
                            })
                        }
                    }
                    if (o().fullCalendar) {
                        var se = new Date((new Date).setHours((new Date).getHours()));
                        se.getDate(), se.getMonth(), o(".calendar").fullCalendar({
                            themeSystem: "bootstrap4",
                            height: "auto",
                            buttonText: {
                                today: "Today",
                                month: "Month",
                                week: "Week",
                                day: "Day",
                                list: "List"
                            },
                            bootstrapFontAwesome: {
                                prev: " simple-icon-arrow-left",
                                next: " simple-icon-arrow-right",
                                prevYear: "simple-icon-control-start",
                                nextYear: "simple-icon-control-end"
                            },
                            events: [{
                                title: "Account",
                                start: "2018-05-18"
                            }, {
                                title: "Delivery",
                                start: "2018-09-22",
                                end: "2018-09-24"
                            }, {
                                title: "Conference",
                                start: "2018-06-07",
                                end: "2018-06-09"
                            }, {
                                title: "Delivery",
                                start: "2018-11-03",
                                end: "2018-11-06"
                            }, {
                                title: "Meeting",
                                start: "2018-10-07",
                                end: "2018-10-09"
                            }, {
                                title: "Taxes",
                                start: "2018-08-07",
                                end: "2018-08-09"
                            }]
                        })
                    }
                    o().DataTable && o(".data-table").DataTable({
                        searching: !1,
                        bLengthChange: !1,
                        destroy: !0,
                        info: !1,
                        sDom: '<"row view-filter"<"col-sm-12"<"pull-left"l><"pull-right"f><"clearfix">>>t<"row view-pager"<"col-sm-12"<"text-center"ip>>>',
                        pageLength: 6,
                        language: {
                            paginate: {
                                previous: "<i class='simple-icon-arrow-left'></i>",
                                next: "<i class='simple-icon-arrow-right'></i>"
                            }
                        },
                        drawCallback: function() {
                            o(o(".dataTables_wrapper .pagination li:first-of-type")).find("a").addClass("prev"), o(o(".dataTables_wrapper .pagination li:last-of-type")).find("a").addClass("next"), o(".dataTables_wrapper .pagination").addClass("pagination-sm")
                        }
                    }), o("body").on("click", ".notify-btn", function(e) {
                        var t, a, n;
                        e.preventDefault(), t = o(this).data("from"), a = o(this).data("align"), n = "primary", o.notify({
                            title: "Bootstrap Notify",
                            message: "Here is a notification!",
                            target: "_blank"
                        }, {
                            element: "body",
                            position: null,
                            type: n,
                            allow_dismiss: !0,
                            newest_on_top: !1,
                            showProgressbar: !1,
                            placement: {
                                from: t,
                                align: a
                            },
                            offset: 20,
                            spacing: 10,
                            z_index: 1031,
                            delay: 4e3,
                            timer: 2e3,
                            url_target: "_blank",
                            mouse_over: null,
                            animate: {
                                enter: "animated fadeInDown",
                                exit: "animated fadeOutUp"
                            },
                            onShow: null,
                            onShown: null,
                            onClose: null,
                            onClosed: null,
                            icon_type: "class",
                            template: '<div data-notify="container" class="col-11 col-sm-3 alert  alert-{0} " role="alert"><button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button><span data-notify="icon"></span> <span data-notify="title">{1}</span> <span data-notify="message">{2}</span><div class="progress" data-notify="progressbar"><div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div></div><a href="{3}" target="{4}" data-notify="url"></a></div>'
                        })
                    }), o().owlCarousel && (o(".owl-carousel.basic").length > 0 && o(".owl-carousel.basic").owlCarousel({
                        margin: 30,
                        stagePadding: 15,
                        dotsContainer: o(".owl-carousel.basic").parents(".owl-container").find(".slider-dot-container"),
                        responsive: {
                            0: {
                                items: 1
                            },
                            600: {
                                items: 2
                            },
                            1000: {
                                items: 3
                            }
                        }
                    }).data("owl.carousel").onResize(), o(".owl-carousel.dashboard-numbers").length > 0 && o(".owl-carousel.dashboard-numbers").owlCarousel({
                        margin: 15,
                        loop: !0,
                        autoplay: !0,
                        stagePadding: 5,
                        responsive: {
                            0: {
                                items: 1
                            },
                            320: {
                                items: 2
                            },
                            576: {
                                items: 3
                            },
                            1200: {
                                items: 3
                            },
                            1440: {
                                items: 3
                            },
                            1800: {
                                items: 4
                            }
                        }
                    }).data("owl.carousel").onResize(), o(".best-rated-items").length > 0 && o(".best-rated-items").owlCarousel({
                        margin: 15,
                        items: 1,
                        loop: !0,
                        autoWidth: !0
                    }).data("owl.carousel").onResize(), o(".owl-carousel.single").length > 0 && o(".owl-carousel.single").owlCarousel({
                        margin: 30,
                        items: 1,
                        loop: !0,
                        stagePadding: 15,
                        dotsContainer: o(".owl-carousel.single").parents(".owl-container").find(".slider-dot-container")
                    }).data("owl.carousel").onResize(), o(".owl-carousel.center").length > 0 && o(".owl-carousel.center").owlCarousel({
                        loop: !0,
                        margin: 30,
                        stagePadding: 15,
                        center: !0,
                        dotsContainer: o(".owl-carousel.center").parents(".owl-container").find(".slider-dot-container"),
                        responsive: {
                            0: {
                                items: 1
                            },
                            480: {
                                items: 2
                            },
                            600: {
                                items: 3
                            },
                            1000: {
                                items: 4
                            }
                        }
                    }).data("owl.carousel").onResize(), o(".owl-dot").click(function() {
                        o(o(this).parents(".owl-container").find(".owl-carousel")).owlCarousel().trigger("to.owl.carousel", [o(this).index(), 300])
                    }), o(".owl-prev").click(function(e) {
                        e.preventDefault(), o(o(this).parents(".owl-container").find(".owl-carousel")).owlCarousel().trigger("prev.owl.carousel", [300])
                    }), o(".owl-next").click(function(e) {
                        e.preventDefault(), o(o(this).parents(".owl-container").find(".owl-carousel")).owlCarousel().trigger("next.owl.carousel", [300])
                    })), o().slick && (o(".slick.basic").slick({
                        dots: !0,
                        infinite: !0,
                        speed: 300,
                        slidesToShow: 3,
                        slidesToScroll: 4,
                        appendDots: o(".slick.basic").parents(".slick-container").find(".slider-dot-container"),
                        prevArrow: o(".slick.basic").parents(".slick-container").find(".slider-nav .left-arrow"),
                        nextArrow: o(".slick.basic").parents(".slick-container").find(".slider-nav .right-arrow"),
                        customPaging: function(e, t) {
                            return '<button role="button" class="slick-dot"><span></span></button>'
                        },
                        responsive: [{
                            breakpoint: 1024,
                            settings: {
                                slidesToShow: 2,
                                slidesToScroll: 2,
                                infinite: !0,
                                dots: !0
                            }
                        }, {
                            breakpoint: 600,
                            settings: {
                                slidesToShow: 1,
                                slidesToScroll: 1
                            }
                        }]
                    }), o(".slick.center").slick({
                        dots: !0,
                        infinite: !0,
                        centerMode: !0,
                        speed: 300,
                        slidesToShow: 4,
                        slidesToScroll: 4,
                        appendDots: o(".slick.center").parents(".slick-container").find(".slider-dot-container"),
                        prevArrow: o(".slick.center").parents(".slick-container").find(".slider-nav .left-arrow"),
                        nextArrow: o(".slick.center").parents(".slick-container").find(".slider-nav .right-arrow"),
                        customPaging: function(e, t) {
                            return '<button role="button" class="slick-dot"><span></span></button>'
                        },
                        responsive: [{
                            breakpoint: 992,
                            settings: {
                                slidesToShow: 3,
                                slidesToScroll: 3,
                                infinite: !0,
                                dots: !0,
                                centerMode: !1
                            }
                        }, {
                            breakpoint: 600,
                            settings: {
                                slidesToShow: 2,
                                slidesToScroll: 2,
                                centerMode: !1
                            }
                        }, {
                            breakpoint: 480,
                            settings: {
                                slidesToShow: 1,
                                slidesToScroll: 1,
                                centerMode: !1
                            }
                        }]
                    }), o(".slick.single").slick({
                        dots: !0,
                        infinite: !0,
                        speed: 300,
                        appendDots: o(".slick.single").parents(".slick-container").find(".slider-dot-container"),
                        prevArrow: o(".slick.single").parents(".slick-container").find(".slider-nav .left-arrow"),
                        nextArrow: o(".slick.single").parents(".slick-container").find(".slider-nav .right-arrow"),
                        customPaging: function(e, t) {
                            return '<button role="button" class="slick-dot"><span></span></button>'
                        }
                    }));
                    var le = document.getElementsByClassName("needs-validation");
                    Array.prototype.filter.call(le, function(e) {
                        e.addEventListener("submit", function(t) {
                            !1 === e.checkValidity() && (t.preventDefault(), t.stopPropagation()), e.classList.add("was-validated")
                        }, !1)
                    }), o().tooltip && o('[data-toggle="tooltip"]').tooltip(), o().popover && o('[data-toggle="popover"]').popover({
                        trigger: "focus"
                    }), o().select2 && o(".select2-single, .select2-multiple").select2({
                        theme: "bootstrap",
                        placeholder: "",
                        maximumSelectionSize: 6,
                        containerCssClass: ":all:"
                    }), o().datepicker && (o("input.datepicker").datepicker({
                        autoclose: !0,
                        templates: {
                            leftArrow: '<i class="simple-icon-arrow-left"></i>',
                            rightArrow: '<i class="simple-icon-arrow-right"></i>'
                        }
                    }), o(".input-daterange").datepicker({
                        autoclose: !0,
                        templates: {
                            leftArrow: '<i class="simple-icon-arrow-left"></i>',
                            rightArrow: '<i class="simple-icon-arrow-right"></i>'
                        }
                    }), o(".input-group.date").datepicker({
                        autoclose: !0,
                        templates: {
                            leftArrow: '<i class="simple-icon-arrow-left"></i>',
                            rightArrow: '<i class="simple-icon-arrow-right"></i>'
                        }
                    }), o(".date-inline").datepicker({
                        autoclose: !0,
                        templates: {
                            leftArrow: '<i class="simple-icon-arrow-left"></i>',
                            rightArrow: '<i class="simple-icon-arrow-right"></i>'
                        }
                    })), o().dropzone && !o(".dropzone").hasClass("disabled") && o(".dropzone").dropzone({
                        url: "/file/post",
                        thumbnailWidth: 160,
                        previewTemplate: '<div class="dz-preview dz-file-preview mb-3"><div class="d-flex flex-row "> <div class="p-0 w-30 position-relative"> <div class="dz-error-mark"><span><i class="simple-icon-exclamation"></i>  </span></div>      <div class="dz-success-mark"><span><i class="simple-icon-check-circle"></i></span></div>      <img data-dz-thumbnail class="img-thumbnail border-0" /> </div> <div class="pl-3 pt-2 pr-2 pb-1 w-70 dz-details position-relative"> <div> <span data-dz-name /> </div> <div class="text-primary text-extra-small" data-dz-size /> </div> <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>        <div class="dz-error-message"><span data-dz-errormessage></span></div>            </div><a href="#" class="remove" data-dz-remove> <i class="simple-icon-trash"></i> </a></div>'
                    });
                    var de, ce = window.Cropper;
                    if (void 0 !== ce) {
                        var ue = function(e, t) {
                                var a, o = e.length;
                                for (a = 0; a < o; a++) t.call(e, e[a], a, e);
                                return e
                            },
                            pe = document.querySelectorAll(".cropper-preview"),
                            he = {
                                aspectRatio: 4 / 3,
                                preview: ".img-preview",
                                ready: function() {
                                    var e = this.cloneNode();
                                    e.className = "", e.style.cssText = "display: block;width: 100%;min-width: 0;min-height: 0;max-width: none;max-height: none;", ue(pe, function(t) {
                                        t.appendChild(e.cloneNode())
                                    })
                                },
                                crop: function(e) {
                                    var t = e.detail,
                                        a = this.cropper.getImageData(),
                                        o = t.width / t.height;
                                    ue(pe, function(e) {
                                        var n = e.getElementsByTagName("img").item(0),
                                            i = e.offsetWidth,
                                            r = i / o,
                                            s = t.width / i;
                                        e.style.height = r + "px", n && (n.style.width = a.naturalWidth / s + "px", n.style.height = a.naturalHeight / s + "px", n.style.marginLeft = -t.x / s + "px", n.style.marginTop = -t.y / s + "px")
                                    })
                                },
                                zoom: function(e) {}
                            };
                        if (o("#inputImage").length > 0) {
                            var me, ge = o("#inputImage")[0],
                                be = o("#cropperImage")[0];
                            ge.onchange = function() {
                                var e, t = this.files;
                                t && t.length && (e = t[0], o("#cropperContainer").css("display", "block"), /^image\/\w+/.test(e.type) ? (uploadedImageType = e.type, uploadedImageName = e.name, be.src = uploadedImageURL = URL.createObjectURL(e), me && me.destroy(), me = new ce(be, he), ge.value = null) : window.alert("Please choose an image file."))
                            }
                        }
                    }

                    function fe() {
                        return document.fullscreenElement && null !== document.fullscreenElement || document.webkitFullscreenElement && null !== document.webkitFullscreenElement || document.mozFullScreenElement && null !== document.mozFullScreenElement || document.msFullscreenElement && null !== document.msFullscreenElement
                    }
                    "undefined" != typeof noUiSlider && (o("#dashboardPriceRange").length > 0 && noUiSlider.create(o("#dashboardPriceRange")[0], {
                        start: [800, 2100],
                        connect: !0,
                        tooltips: !0,
                        range: {
                            min: 200,
                            max: 2800
                        },
                        step: 10,
                        format: {
                            to: function(e) {
                                return "$" + o.fn.addCommas(Math.floor(e))
                            },
                            from: function(e) {
                                return e
                            }
                        }
                    }), o("#doubleSlider").length > 0 && noUiSlider.create(o("#doubleSlider")[0], {
                        start: [800, 1200],
                        connect: !0,
                        tooltips: !0,
                        range: {
                            min: 500,
                            max: 1500
                        },
                        step: 10,
                        format: {
                            to: function(e) {
                                return "$" + o.fn.addCommas(Math.round(e))
                            },
                            from: function(e) {
                                return e
                            }
                        }
                    }), o("#singleSlider").length > 0 && noUiSlider.create(o("#singleSlider")[0], {
                        start: 0,
                        connect: !0,
                        tooltips: !0,
                        range: {
                            min: 0,
                            max: 150
                        },
                        step: 1,
                        format: {
                            to: function(e) {
                                return o.fn.addCommas(Math.round(e))
                            },
                            from: function(e) {
                                return e
                            }
                        }
                    })), o("#exampleModalContent").on("show.bs.modal", function(e) {
                        var t = o(e.relatedTarget).data("whatever"),
                            a = o(this);
                        a.find(".modal-title").text("New message to " + t), a.find(".modal-body input").val(t)
                    }), "undefined" != typeof PerfectScrollbar && o(".scroll").each(function() {
                        if (o(this).parents(".chat-app").length > 0) return de = new PerfectScrollbar(o(this)[0]), o(".chat-app .scroll").scrollTop(o(".chat-app .scroll").prop("scrollHeight")), void de.update();
                        new PerfectScrollbar(o(this)[0])
                    }), o(".progress-bar").each(function() {
                        o(this).css("width", o(this).attr("aria-valuenow") + "%")
                    }), "undefined" != typeof ProgressBar && o(".progress-bar-circle").each(function() {
                        var e = o(this).attr("aria-valuenow"),
                            a = o(this).data("color") || t,
                            n = o(this).data("trailColor") || "#d7d7d7",
                            i = o(this).attr("aria-valuemax") || 100,
                            r = o(this).data("showPercent");
                        new ProgressBar.Circle(this, {
                            color: a,
                            duration: 20,
                            easing: "easeInOut",
                            strokeWidth: 4,
                            trailColor: n,
                            trailWidth: 4,
                            text: {
                                autoStyleContainer: !1
                            },
                            step: function(t, a) {
                                r ? a.setText(Math.round(100 * a.value()) + "%") : a.setText(e + "/" + i)
                            }
                        }).animate(e / i)
                    }), o().barrating && o(".rating").each(function() {
                        var e = o(this).data("currentRating"),
                            t = o(this).data("readonly");
                        o(this).barrating({
                            theme: "bootstrap-stars",
                            initialRating: e,
                            readonly: t
                        })
                    }), o().tagsinput && (o(".tags").tagsinput({
                        cancelConfirmKeysOnEmpty: !0,
                        confirmKeys: [13]
                    }), o("body").on("keypress", ".bootstrap-tagsinput input", function(e) {
                        13 == e.which && (e.preventDefault(), e.stopPropagation())
                    })), "undefined" != typeof Sortable && (o(".sortable").each(function() {
                        o(this).find(".handle").length > 0 ? Sortable.create(o(this)[0], {
                            handle: ".handle"
                        }) : Sortable.create(o(this)[0])
                    }), o(".sortable-survey").length > 0 && Sortable.create(o(".sortable-survey")[0])), o("#successButton").on("click", function(e) {
                        e.preventDefault();
                        var t = o(this);
                        t.hasClass("show-fail") || t.hasClass("show-spinner") || t.hasClass("show-success") || (t.addClass("show-spinner"), t.addClass("active"), setTimeout(function() {
                            t.addClass("show-success"), t.removeClass("show-spinner"), t.find(".icon.success").tooltip("show"), setTimeout(function() {
                                t.removeClass("show-success"), t.removeClass("active"), t.find(".icon.success").tooltip("dispose")
                            }, 2e3)
                        }, 3e3))
                    }), o("#failButton").on("click", function(e) {
                        e.preventDefault();
                        var t = o(this);
                        t.hasClass("show-fail") || t.hasClass("show-spinner") || t.hasClass("show-success") || (t.addClass("show-spinner"), t.addClass("active"), setTimeout(function() {
                            t.addClass("show-fail"), t.removeClass("show-spinner"), t.find(".icon.fail").tooltip("show"), setTimeout(function() {
                                t.removeClass("show-fail"), t.removeClass("active"), t.find(".icon.fail").tooltip("dispose")
                            }, 2e3)
                        }, 3e3))
                    }), o().typeahead && o("#query").typeahead({
                        source: [{
                            name: "May",
                            index: 0,
                            id: "5a8a9bfd8bf389ba8d6bb211"
                        }, {
                            name: "Fuentes",
                            index: 1,
                            id: "5a8a9bfdee10e107f28578d4"
                        }, {
                            name: "Henderson",
                            index: 2,
                            id: "5a8a9bfd4f9e224dfa0110f3"
                        }, {
                            name: "Hinton",
                            index: 3,
                            id: "5a8a9bfde42b28e85df34630"
                        }, {
                            name: "Barrera",
                            index: 4,
                            id: "5a8a9bfdc0cba3abc4532d8d"
                        }, {
                            name: "Therese",
                            index: 5,
                            id: "5a8a9bfdedfcd1aa0f4c414e"
                        }, {
                            name: "Nona",
                            index: 6,
                            id: "5a8a9bfdd6686aa51b953c4e"
                        }, {
                            name: "Frye",
                            index: 7,
                            id: "5a8a9bfd352e2fd4c101507d"
                        }, {
                            name: "Cora",
                            index: 8,
                            id: "5a8a9bfdb5133142047f2600"
                        }, {
                            name: "Miles",
                            index: 9,
                            id: "5a8a9bfdadb1afd136117928"
                        }, {
                            name: "Cantrell",
                            index: 10,
                            id: "5a8a9bfdca4795bcbb002057"
                        }, {
                            name: "Benson",
                            index: 11,
                            id: "5a8a9bfdaa51e9a4aeeddb7d"
                        }, {
                            name: "Susanna",
                            index: 12,
                            id: "5a8a9bfd57dd857535ef5998"
                        }, {
                            name: "Beatrice",
                            index: 13,
                            id: "5a8a9bfd68b6f12828da4175"
                        }, {
                            name: "Tameka",
                            index: 14,
                            id: "5a8a9bfd2bc4a368244d5253"
                        }, {
                            name: "Lowe",
                            index: 15,
                            id: "5a8a9bfd9004fda447204d30"
                        }, {
                            name: "Roth",
                            index: 16,
                            id: "5a8a9bfdb4616dbc06af6172"
                        }, {
                            name: "Conley",
                            index: 17,
                            id: "5a8a9bfdfae43320dd8f9c5a"
                        }, {
                            name: "Nelda",
                            index: 18,
                            id: "5a8a9bfd534d9e0ba2d7c9a7"
                        }, {
                            name: "Angie",
                            index: 19,
                            id: "5a8a9bfd57de84496dc42259"
                        }]
                    }), o("#fullScreenButton").on("click", function(e) {
                        var t, a;
                        e.preventDefault(), fe() ? (o(o(this).find("i")[1]).css("display", "none"), o(o(this).find("i")[0]).css("display", "inline")) : (o(o(this).find("i")[1]).css("display", "inline"), o(o(this).find("i")[0]).css("display", "none")), t = fe(), a = document.documentElement, t ? document.exitFullscreen ? document.exitFullscreen() : document.webkitExitFullscreen ? document.webkitExitFullscreen() : document.mozCancelFullScreen ? document.mozCancelFullScreen() : document.msExitFullscreen && document.msExitFullscreen() : a.requestFullscreen ? a.requestFullscreen() : a.mozRequestFullScreen ? a.mozRequestFullScreen() : a.webkitRequestFullScreen ? a.webkitRequestFullScreen() : a.msRequestFullscreen && a.msRequestFullscreen()
                    }), "undefined" != typeof Quill && (new Quill("#quillEditor", {
                        modules: {
                            toolbar: [
                                ["bold", "italic", "underline", "strike"],
                                ["blockquote", "code-block"],
                                [{
                                    header: 1
                                }, {
                                    header: 2
                                }],
                                [{
                                    list: "ordered"
                                }, {
                                    list: "bullet"
                                }],
                                [{
                                    script: "sub"
                                }, {
                                    script: "super"
                                }],
                                [{
                                    indent: "-1"
                                }, {
                                    indent: "+1"
                                }],
                                [{
                                    direction: "rtl"
                                }],
                                [{
                                    size: ["small", !1, "large", "huge"]
                                }],
                                [{
                                    header: [1, 2, 3, 4, 5, 6, !1]
                                }],
                                [{
                                    color: []
                                }, {
                                    background: []
                                }],
                                [{
                                    font: []
                                }],
                                [{
                                    align: []
                                }],
                                ["clean"]
                            ]
                        },
                        theme: "snow"
                    }), new Quill("#quillEditorBubble", {
                        modules: {
                            toolbar: [
                                ["bold", "italic", "underline", "strike"],
                                [{
                                    list: "ordered"
                                }, {
                                    list: "bullet"
                                }],
                                [{
                                    size: ["small", !1, "large", "huge"]
                                }],
                                [{
                                    color: []
                                }],
                                [{
                                    align: []
                                }]
                            ]
                        },
                        theme: "bubble"
                    }));
                    "undefined" != typeof ClassicEditor && ClassicEditor.create(document.querySelector("#ckEditorClassic")).catch(function(e) {}), o("body > *").stop().delay(100).animate({
                        opacity: 1
                    }, 300), o("body").removeClass("show-spinner"), o("main").addClass("default-transition"), o(".sub-menu").addClass("default-transition"), o(".main-menu").addClass("default-transition"), o(".theme-colors").addClass("default-transition"), "undefined" != typeof Mousetrap && (Mousetrap.bind(["ctrl+down", "command+down"], function(e) {
                        var t = o(".sub-menu li.active").next();
                        return 0 == t.length && (t = o(".sub-menu li.active").parent().children().first()), window.location.href = t.find("a").attr("href"), !1
                    }), Mousetrap.bind(["ctrl+up", "command+up"], function(e) {
                        var t = o(".sub-menu li.active").prev();
                        return 0 == t.length && (t = o(".sub-menu li.active").parent().children().last()), window.location.href = t.find("a").attr("href"), !1
                    }), Mousetrap.bind(["ctrl+shift+down", "command+shift+down"], function(e) {
                        var t = o(".main-menu li.active").next();
                        0 == t.length && (t = o(".main-menu li:first-of-type"));
                        var a = t.find("a").attr("href").replace("#", ""),
                            n = o(".sub-menu ul[data-link='" + a + "'] li:first-of-type");
                        return window.location.href = n.find("a").attr("href"), !1
                    }), Mousetrap.bind(["ctrl+shift+up", "command+shift+up"], function(e) {
                        var t = o(".main-menu li.active").prev();
                        0 == t.length && (t = o(".main-menu li:last-of-type"));
                        var a = t.find("a").attr("href").replace("#", ""),
                            n = o(".sub-menu ul[data-link='" + a + "'] li:first-of-type");
                        return window.location.href = n.find("a").attr("href"), !1
                    }), o(".list") && o(".list").length > 0 && (Mousetrap.bind(["ctrl+a", "command+a"], function(e) {
                        return o(".list").shiftSelectable().data("shiftSelectable").selectAll(), !1
                    }), Mousetrap.bind(["ctrl+d", "command+d"], function(e) {
                        return o(".list").shiftSelectable().data("shiftSelectable").deSelectAll(), !1
                    }))), o().contextMenu && o.contextMenu({
                        selector: ".list .card",
                        callback: function(e, t) {},
                        events: {
                            show: function(e) {
                                var t = e.$trigger.parents(".list");
                                t && t.length > 0 && t.data("shiftSelectable").rightClick(e.$trigger)
                            }
                        },
                        items: {
                            copy: {
                                name: "Copy",
                                className: "simple-icon-docs"
                            },
                            archive: {
                                name: "Move to archive",
                                className: "simple-icon-drawer"
                            },
                            delete: {
                                name: "Delete",
                                className: "simple-icon-trash"
                            }
                        }
                    }), o().selectFromLibrary && (o(".sfl-multiple").selectFromLibrary(), o(".sfl-single").selectFromLibrary())
                }()
            }, o.fn.dore = function(e) {
                return this.each(function() {
                    if (null == o(this).data("dore")) {
                        var t = new o.dore(this, e);
                        o(this).data("dore", t)
                    }
                })
            }
        }
    },
    [
        ["+UE2", "runtime", 0]
    ]
]);