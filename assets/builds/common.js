/*!
 * Internal App Plugin for validation that extends jQuery Validation plugin.
 *
 * https://finishizer.net/
 *
 * Copyright (c) 2019 Marjan Stojanov
 */

if (typeof $.validator == "undefined") {
  throw new Error(
    'jQuery Validation plugin not found. "appFormValidator" requires jQuery Validation >= v1.17.0'
  );
}

(function ($) {
  var configuredjQueryValidation = false;

  $.fn.appFormValidator = function (options) {
    var self = this;

    var defaultMessages = {
      email: {
        remote:
          $.fn.appFormValidator.internal_options.localization.email_exists,
      },
    };

    var defaults = {
      rules: [],
      messages: [],
      ignore: [],
      onSubmit: false,
      submitHandler: function (form) {
        var $form = $(form);

        if ($form.hasClass("disable-on-submit")) {
          $form.find('[type="submit"]').prop("disabled", true);
        }

        var loadingBtn = $form.find("[data-loading-text]");

        if (loadingBtn.length > 0) {
          loadingBtn.button("loading");
        }

        if (settings.onSubmit) {
          settings.onSubmit(form);
        } else {
          return true;
        }
      },
    };

    var settings = $.extend({}, defaults, options);

    // Just make sure that this is always configured
    if (typeof settings.messages.email == "undefined") {
      settings.messages.email = defaultMessages.email;
    }

    self.configureJqueryValidationDefaults = function () {
      // Set this only 1 time before the first validation happens
      if (!configuredjQueryValidation) {
        configuredjQueryValidation = true;
      } else {
        return true;
      }

      // Jquery validate set default options
      $.validator.setDefaults({
        highlight: $.fn.appFormValidator.internal_options.error_highlight,
        unhighlight: $.fn.appFormValidator.internal_options.error_unhighlight,
        errorElement: $.fn.appFormValidator.internal_options.error_element,
        errorClass: $.fn.appFormValidator.internal_options.error_class,
        errorPlacement: $.fn.appFormValidator.internal_options.error_placement,
      });

      self.addMethodFileSize();
      self.addMethodExtension();
    };

    self.addMethodFileSize = function () {
      // New validation method filesize
      $.validator.addMethod(
        "filesize",
        function (value, element, param) {
          return this.optional(element) || element.files[0].size <= param;
        },
        $.fn.appFormValidator.internal_options.localization
          .file_exceeds_max_filesize
      );
    };

    self.addMethodExtension = function () {
      // New validation method extension based on app extensions
      $.validator.addMethod(
        "extension",
        function (value, element, param) {
          param =
            typeof param === "string"
              ? param.replace(/,/g, "|")
              : "png|jpe?g|gif";
          return (
            this.optional(element) ||
            value.match(new RegExp("\\.(" + param + ")$", "i"))
          );
        },
        $.fn.appFormValidator.internal_options.localization
          .validation_extension_not_allowed
      );
    };

    self.validateCustomFields = function ($form) {
      $.each(
        $form.find(
          $.fn.appFormValidator.internal_options.required_custom_fields_selector
        ),
        function () {
          // for custom fields in tr.main, do not validate those
          if (
            !$(this).parents("tr.main").length &&
            !$(this).hasClass("do-not-validate")
          ) {
            $(this).rules("add", { required: true });
            if ($.fn.appFormValidator.internal_options.on_required_add_symbol) {
              var label = $(this)
                .parents(
                  "." +
                    $.fn.appFormValidator.internal_options.field_wrapper_class
                )
                .find('[for="' + $(this).attr("name") + '"]');
              if (label.length > 0 && label.find(".req").length === 0) {
                label.prepend('<small class="req text-danger">* </small>');
              }
            }
          }
        }
      );
    };

    self.addRequiredFieldSymbol = function ($form) {
      if ($.fn.appFormValidator.internal_options.on_required_add_symbol) {
        $.each(settings.rules, function (name, rule) {
          if (
            (rule == "required" && !jQuery.isPlainObject(rule)) ||
            (jQuery.isPlainObject(rule) && rule.hasOwnProperty("required"))
          ) {
            var label = $form.find('[for="' + name + '"]');
            if (label.length > 0 && label.find(".req").length === 0) {
              label.prepend(' <small class="req text-danger">* </small>');
            }
          }
        });
      }
    };

    self.configureJqueryValidationDefaults();

    return self.each(function () {
      var $form = $(this);

      // If already validated, destroy to free up memory
      if ($form.data("validator")) {
        $form.data("validator").destroy();
      }

      $form.validate(settings);
      self.validateCustomFields($form);
      self.addRequiredFieldSymbol($form);

      $(document).trigger("app.form-validate", $form);
    });
  };
})(jQuery);

$.fn.appFormValidator.internal_options = {
  localization: {
    email_exists:
      typeof app != "undefined"
        ? app.lang.email_exists
        : "Please fix this field",
    file_exceeds_max_filesize:
      typeof app != "undefined"
        ? app.lang.file_exceeds_max_filesize
        : "File Exceeds Max Filesize",
    validation_extension_not_allowed:
      typeof app != "undefined"
        ? $.validator.format(app.lang.validation_extension_not_allowed)
        : $.validator.format("Extension not allowed"),
  },
  on_required_add_symbol: true,
  error_class: "text-danger",
  error_element: "p",
  required_custom_fields_selector: "[data-custom-field-required]",
  field_wrapper_class: "form-group",
  field_wrapper_error_class: "has-error",
  tab_panel_wrapper: "tab-pane",
  validated_tab_class: "tab-validated",
  error_placement: function (error, element) {
    if (
      element.parent(".input-group").length ||
      element.parents(".chk").length
    ) {
      if (!element.parents(".chk").length) {
        error.insertAfter(element.parent());
      } else {
        error.insertAfter(element.parents(".chk"));
      }
    } else if (
      element.is("select") &&
      (element.hasClass("selectpicker") || element.hasClass("ajax-search"))
    ) {
      error.insertAfter(
        element
          .parents(
            "." +
              $.fn.appFormValidator.internal_options.field_wrapper_class +
              " *"
          )
          .last()
      );
    } else {
      error.insertAfter(element);
    }
  },
  error_highlight: function (element) {
    var $child_tab_in_form = $(element).closest(
      "." + $.fn.appFormValidator.internal_options.tab_panel_wrapper
    );

    if ($child_tab_in_form.length && !$child_tab_in_form.is(":visible")) {
      $('a[href="#' + $child_tab_in_form.attr("id") + '"]')
        .css("border-bottom", "1px solid red")
        .css("color", "red")
        .addClass($.fn.appFormValidator.internal_options.validated_tab_class);
    }

    if ($(element).is("select")) {
      // Having some issues with select, it's not aways highlighting good or too fast doing unhighlight
      delay(function () {
        $(element)
          .closest(
            "." + $.fn.appFormValidator.internal_options.field_wrapper_class
          )
          .addClass(
            $.fn.appFormValidator.internal_options.field_wrapper_error_class
          );
      }, 400);
    } else {
      $(element)
        .closest(
          "." + $.fn.appFormValidator.internal_options.field_wrapper_class
        )
        .addClass(
          $.fn.appFormValidator.internal_options.field_wrapper_error_class
        );
    }
  },
  error_unhighlight: function (element) {
    element = $(element);
    var $child_tab_in_form = element.closest(
      "." + $.fn.appFormValidator.internal_options.tab_panel_wrapper
    );
    element
      .closest("." + $.fn.appFormValidator.internal_options.field_wrapper_class)
      .removeClass(
        $.fn.appFormValidator.internal_options.field_wrapper_error_class
      );

    if (
      $child_tab_in_form.length &&
      $child_tab_in_form.find(
        "." + $.fn.appFormValidator.internal_options.field_wrapper_error_class
      ).length === 0
    ) {
      $('a[href="#' + $child_tab_in_form.attr("id") + '"]')
        .removeAttr("style")
        .removeClass(
          $.fn.appFormValidator.internal_options.validated_tab_class
        );
    }
  },
};

jQuery.extend({
    highlight: function(node, re, nodeName, className) {
        if (node.nodeType === 3) {
            var match = node.data.match(re);
            if (match) {

                var highlight = document.createElement(nodeName || 'span');
                highlight.className = className || 'highlight';
                var wordNode = node.splitText(match.index);
                wordNode.splitText(match[0].length);
                var wordClone = wordNode.cloneNode(true);

                if (wordNode.parentNode.tagName && wordNode.parentNode.tagName.toLowerCase() !== 'textarea') {
                    highlight.appendChild(wordClone);
                    wordNode.parentNode.replaceChild(highlight, wordNode);
                }
                return 1; //skip added node in parent
            }
        } else if ((node.nodeType === 1 && node.childNodes) && // only element nodes that have children
            !/(script|style)/i.test(node.tagName) && // ignore script and style nodes
            !(node.tagName === nodeName.toUpperCase() && node.className === className)) { // skip if already highlighted
            for (var i = 0; i < node.childNodes.length; i++) {
                i += jQuery.highlight(node.childNodes[i], re, nodeName, className);
            }
        }
        return 0;
    }
});

jQuery.fn.highlight = function(words, options) {
    var settings = {
        className: 'highlight animated flash',
        element: 'span',
        caseSensitive: false,
        wordsOnly: false
    };
    jQuery.extend(settings, options);

    if (words.constructor === String) {
        words = [words];
    }
    words = jQuery.grep(words, function(word, i) {
        return word != '';
    });
    words = jQuery.map(words, function(word, i) {
        return word.replace(/[-[\]{}()*+?.,\\^$|#\s]/g, "\\$&");
    });
    if (words.length == 0) {
        return this;
    };
    var flag = settings.caseSensitive ? "" : "i";
    var pattern = "(" + words.join("|") + ")";
    if (settings.wordsOnly) {
        pattern = "\\b" + pattern + "\\b";
    }
    var re = new RegExp(pattern, flag);

    return this.each(function() {
        jQuery.highlight(this, re, settings.element, settings.className);
    });
};

jQuery.fn.unhighlight = function(options) {
    var settings = {
        className: 'highlight',
        element: 'span'
    };
    jQuery.extend(settings, options);
    return this.find(settings.element + "." + settings.className)
        .each(function() {
            var parent = this.parentNode;
            parent.replaceChild(this.firstChild, this);
            parent.normalize();
        })
        .end();
};

/*!
 * Internal Google Drive Picker Plugin.
 *
 * https://finishizer.net/
 *
 * Copyright (c) 2019 Marjan Stojanov
 */

(function($) {

    $.fn.googleDrivePicker = function(options) {

        var pickerApiLoaded = false;
        var oauthToken;

        var internal = {
            // Use the API Loader script to load google.picker and gapi.auth.
            initGooglePickerAPI: function(element) {
                gapi.load('auth2', function() {
                    internal.onAuthApiLoad(element)
                });
                gapi.load('picker', internal.onPickerApiLoad);
            },
            onAuthApiLoad: function(element) {
                element.disabled = false;
                element.addEventListener('click', function() {
                    gapi.auth2.authorize({
                        client_id: settings.clientId,
                        scope: settings.scope
                    }, internal.handleAuthResult);
                });
            },
            onPickerApiLoad: function() {
                pickerApiLoaded = true;
                internal.createPicker();
            },
            handleAuthResult: function(authResult) {
                if (authResult && !authResult.error) {
                    oauthToken = authResult.access_token;
                    internal.createPicker();
                } else if (authResult.error) {
                    console.error(authResult)
                }
            },
            createPicker: function() {
                if (pickerApiLoaded && oauthToken) {
                    var view = new google.picker.DocsView()
                        .setIncludeFolders(true);
                    var uploadView = new google.picker.DocsUploadView()
                        .setIncludeFolders(true);

                    if (settings.mimeTypes) {
                        view.setMimeTypes(settings.mimeTypes);
                        uploadView.setMimeTypes(settings.mimeTypes);
                    }

                    new google.picker.PickerBuilder()
                        .addView(view)
                        //.enableFeature(google.picker.Feature.MULTISELECT_ENABLED)
                        .addView(uploadView)
                        .setOAuthToken(oauthToken)
                        .setDeveloperKey(settings.developerKey)
                        .setCallback(internal.pickerCallback)
                        .build()
                        .setVisible(true);

                    setTimeout(function() {
                        $('.picker-dialog')
                            .css('z-index', 10002);
                    }, 20);
                }
            },
            pickerCallback: function(data) {
                var url;
                if (data[google.picker.Response.ACTION] == google.picker.Action.PICKED) {
                    var retVal = [];

                    data[google.picker.Response.DOCUMENTS].forEach(function(doc) {
                        retVal.push({
                            name: doc[google.picker.Document.NAME],
                            link: doc[google.picker.Document.URL],
                            mime: doc[google.picker.Document.MIME_TYPE],
                        })
                    })

                    typeof(settings.onPick) == 'function' ? settings.onPick(retVal): window[settings.onPick](retVal);
                }
            }
        }

        var settings = $.extend({}, $.fn.googleDrivePicker.defaults, options);

        return this.each(function() {
            if (settings.clientId) {
                if ($(this)
                    .data('on-pick')) {
                    settings.onPick = $(this)
                        .data('on-pick')
                }
                internal.initGooglePickerAPI($(this)[0]);
                $(this)
                    .css('opacity', 1)
            } else {
                // Not configured
                $(this)
                    .css('opacity', 0);
            }
        });
    };
}(jQuery));

$.fn.googleDrivePicker.defaults = {
    scope: 'https://www.googleapis.com/auth/drive',
    mimeTypes: null,
    // The Browser API key obtained from the Google API Console.
    developerKey: '',
    // The Client ID obtained from the Google API Console. Replace with your own Client ID.
    clientId: '',
    onPick: function(data) {}
}

/*!
Waypoints - 4.0.1
Copyright © 2011-2016 Caleb Troughton
Licensed under the MIT license.
https://github.com/imakewebthings/waypoints/blob/master/licenses.txt
*/
!function(){"use strict";function t(o){if(!o)throw new Error("No options passed to Waypoint constructor");if(!o.element)throw new Error("No element option passed to Waypoint constructor");if(!o.handler)throw new Error("No handler option passed to Waypoint constructor");this.key="waypoint-"+e,this.options=t.Adapter.extend({},t.defaults,o),this.element=this.options.element,this.adapter=new t.Adapter(this.element),this.callback=o.handler,this.axis=this.options.horizontal?"horizontal":"vertical",this.enabled=this.options.enabled,this.triggerPoint=null,this.group=t.Group.findOrCreate({name:this.options.group,axis:this.axis}),this.context=t.Context.findOrCreateByElement(this.options.context),t.offsetAliases[this.options.offset]&&(this.options.offset=t.offsetAliases[this.options.offset]),this.group.add(this),this.context.add(this),i[this.key]=this,e+=1}var e=0,i={};t.prototype.queueTrigger=function(t){this.group.queueTrigger(this,t)},t.prototype.trigger=function(t){this.enabled&&this.callback&&this.callback.apply(this,t)},t.prototype.destroy=function(){this.context.remove(this),this.group.remove(this),delete i[this.key]},t.prototype.disable=function(){return this.enabled=!1,this},t.prototype.enable=function(){return this.context.refresh(),this.enabled=!0,this},t.prototype.next=function(){return this.group.next(this)},t.prototype.previous=function(){return this.group.previous(this)},t.invokeAll=function(t){var e=[];for(var o in i)e.push(i[o]);for(var n=0,r=e.length;r>n;n++)e[n][t]()},t.destroyAll=function(){t.invokeAll("destroy")},t.disableAll=function(){t.invokeAll("disable")},t.enableAll=function(){t.Context.refreshAll();for(var e in i)i[e].enabled=!0;return this},t.refreshAll=function(){t.Context.refreshAll()},t.viewportHeight=function(){return window.innerHeight||document.documentElement.clientHeight},t.viewportWidth=function(){return document.documentElement.clientWidth},t.adapters=[],t.defaults={context:window,continuous:!0,enabled:!0,group:"default",horizontal:!1,offset:0},t.offsetAliases={"bottom-in-view":function(){return this.context.innerHeight()-this.adapter.outerHeight()},"right-in-view":function(){return this.context.innerWidth()-this.adapter.outerWidth()}},window.Waypoint=t}(),function(){"use strict";function t(t){window.setTimeout(t,1e3/60)}function e(t){this.element=t,this.Adapter=n.Adapter,this.adapter=new this.Adapter(t),this.key="waypoint-context-"+i,this.didScroll=!1,this.didResize=!1,this.oldScroll={x:this.adapter.scrollLeft(),y:this.adapter.scrollTop()},this.waypoints={vertical:{},horizontal:{}},t.waypointContextKey=this.key,o[t.waypointContextKey]=this,i+=1,n.windowContext||(n.windowContext=!0,n.windowContext=new e(window)),this.createThrottledScrollHandler(),this.createThrottledResizeHandler()}var i=0,o={},n=window.Waypoint,r=window.onload;e.prototype.add=function(t){var e=t.options.horizontal?"horizontal":"vertical";this.waypoints[e][t.key]=t,this.refresh()},e.prototype.checkEmpty=function(){var t=this.Adapter.isEmptyObject(this.waypoints.horizontal),e=this.Adapter.isEmptyObject(this.waypoints.vertical),i=this.element==this.element.window;t&&e&&!i&&(this.adapter.off(".waypoints"),delete o[this.key])},e.prototype.createThrottledResizeHandler=function(){function t(){e.handleResize(),e.didResize=!1}var e=this;this.adapter.on("resize.waypoints",function(){e.didResize||(e.didResize=!0,n.requestAnimationFrame(t))})},e.prototype.createThrottledScrollHandler=function(){function t(){e.handleScroll(),e.didScroll=!1}var e=this;this.adapter.on("scroll.waypoints",function(){(!e.didScroll||n.isTouch)&&(e.didScroll=!0,n.requestAnimationFrame(t))})},e.prototype.handleResize=function(){n.Context.refreshAll()},e.prototype.handleScroll=function(){var t={},e={horizontal:{newScroll:this.adapter.scrollLeft(),oldScroll:this.oldScroll.x,forward:"right",backward:"left"},vertical:{newScroll:this.adapter.scrollTop(),oldScroll:this.oldScroll.y,forward:"down",backward:"up"}};for(var i in e){var o=e[i],n=o.newScroll>o.oldScroll,r=n?o.forward:o.backward;for(var s in this.waypoints[i]){var a=this.waypoints[i][s];if(null!==a.triggerPoint){var l=o.oldScroll<a.triggerPoint,h=o.newScroll>=a.triggerPoint,p=l&&h,u=!l&&!h;(p||u)&&(a.queueTrigger(r),t[a.group.id]=a.group)}}}for(var c in t)t[c].flushTriggers();this.oldScroll={x:e.horizontal.newScroll,y:e.vertical.newScroll}},e.prototype.innerHeight=function(){return this.element==this.element.window?n.viewportHeight():this.adapter.innerHeight()},e.prototype.remove=function(t){delete this.waypoints[t.axis][t.key],this.checkEmpty()},e.prototype.innerWidth=function(){return this.element==this.element.window?n.viewportWidth():this.adapter.innerWidth()},e.prototype.destroy=function(){var t=[];for(var e in this.waypoints)for(var i in this.waypoints[e])t.push(this.waypoints[e][i]);for(var o=0,n=t.length;n>o;o++)t[o].destroy()},e.prototype.refresh=function(){var t,e=this.element==this.element.window,i=e?void 0:this.adapter.offset(),o={};this.handleScroll(),t={horizontal:{contextOffset:e?0:i.left,contextScroll:e?0:this.oldScroll.x,contextDimension:this.innerWidth(),oldScroll:this.oldScroll.x,forward:"right",backward:"left",offsetProp:"left"},vertical:{contextOffset:e?0:i.top,contextScroll:e?0:this.oldScroll.y,contextDimension:this.innerHeight(),oldScroll:this.oldScroll.y,forward:"down",backward:"up",offsetProp:"top"}};for(var r in t){var s=t[r];for(var a in this.waypoints[r]){var l,h,p,u,c,d=this.waypoints[r][a],f=d.options.offset,w=d.triggerPoint,y=0,g=null==w;d.element!==d.element.window&&(y=d.adapter.offset()[s.offsetProp]),"function"==typeof f?f=f.apply(d):"string"==typeof f&&(f=parseFloat(f),d.options.offset.indexOf("%")>-1&&(f=Math.ceil(s.contextDimension*f/100))),l=s.contextScroll-s.contextOffset,d.triggerPoint=Math.floor(y+l-f),h=w<s.oldScroll,p=d.triggerPoint>=s.oldScroll,u=h&&p,c=!h&&!p,!g&&u?(d.queueTrigger(s.backward),o[d.group.id]=d.group):!g&&c?(d.queueTrigger(s.forward),o[d.group.id]=d.group):g&&s.oldScroll>=d.triggerPoint&&(d.queueTrigger(s.forward),o[d.group.id]=d.group)}}return n.requestAnimationFrame(function(){for(var t in o)o[t].flushTriggers()}),this},e.findOrCreateByElement=function(t){return e.findByElement(t)||new e(t)},e.refreshAll=function(){for(var t in o)o[t].refresh()},e.findByElement=function(t){return o[t.waypointContextKey]},window.onload=function(){r&&r(),e.refreshAll()},n.requestAnimationFrame=function(e){var i=window.requestAnimationFrame||window.mozRequestAnimationFrame||window.webkitRequestAnimationFrame||t;i.call(window,e)},n.Context=e}(),function(){"use strict";function t(t,e){return t.triggerPoint-e.triggerPoint}function e(t,e){return e.triggerPoint-t.triggerPoint}function i(t){this.name=t.name,this.axis=t.axis,this.id=this.name+"-"+this.axis,this.waypoints=[],this.clearTriggerQueues(),o[this.axis][this.name]=this}var o={vertical:{},horizontal:{}},n=window.Waypoint;i.prototype.add=function(t){this.waypoints.push(t)},i.prototype.clearTriggerQueues=function(){this.triggerQueues={up:[],down:[],left:[],right:[]}},i.prototype.flushTriggers=function(){for(var i in this.triggerQueues){var o=this.triggerQueues[i],n="up"===i||"left"===i;o.sort(n?e:t);for(var r=0,s=o.length;s>r;r+=1){var a=o[r];(a.options.continuous||r===o.length-1)&&a.trigger([i])}}this.clearTriggerQueues()},i.prototype.next=function(e){this.waypoints.sort(t);var i=n.Adapter.inArray(e,this.waypoints),o=i===this.waypoints.length-1;return o?null:this.waypoints[i+1]},i.prototype.previous=function(e){this.waypoints.sort(t);var i=n.Adapter.inArray(e,this.waypoints);return i?this.waypoints[i-1]:null},i.prototype.queueTrigger=function(t,e){this.triggerQueues[e].push(t)},i.prototype.remove=function(t){var e=n.Adapter.inArray(t,this.waypoints);e>-1&&this.waypoints.splice(e,1)},i.prototype.first=function(){return this.waypoints[0]},i.prototype.last=function(){return this.waypoints[this.waypoints.length-1]},i.findOrCreate=function(t){return o[t.axis][t.name]||new i(t)},n.Group=i}(),function(){"use strict";function t(t){this.$element=e(t)}var e=window.jQuery,i=window.Waypoint;e.each(["innerHeight","innerWidth","off","offset","on","outerHeight","outerWidth","scrollLeft","scrollTop"],function(e,i){t.prototype[i]=function(){var t=Array.prototype.slice.call(arguments);return this.$element[i].apply(this.$element,t)}}),e.each(["extend","inArray","isEmptyObject"],function(i,o){t[o]=e[o]}),i.adapters.push({name:"jquery",Adapter:t}),i.Adapter=t}(),function(){"use strict";function t(t){return function(){var i=[],o=arguments[0];return t.isFunction(arguments[0])&&(o=t.extend({},arguments[1]),o.handler=arguments[0]),this.each(function(){var n=t.extend({},o,{element:this});"string"==typeof n.context&&(n.context=t(this).closest(n.context)[0]),i.push(new e(n))}),i}}var e=window.Waypoint;window.jQuery&&(window.jQuery.fn.waypoint=t(window.jQuery)),window.Zepto&&(window.Zepto.fn.waypoint=t(window.Zepto))}();
// Add Horizontal Tabs to jquery
// Modified version

(function($) {


    (function($, sr) {

        // debouncing function from John Hann
        // http://unscriptable.com/index.php/2009/03/20/debouncing-javascript-methods/
        var debounce = function(func, threshold, execAsap) {
            var timeout;

            return function debounced() {
                var obj = this,
                    args = arguments;

                function delayed() {
                    if (!execAsap)
                        func.apply(obj, args);
                    timeout = null;
                };

                if (timeout)
                    clearTimeout(timeout);
                else if (execAsap)
                    func.apply(obj, args);

                timeout = setTimeout(delayed, threshold || 100);
            };
        }
        // smartresize
        jQuery.fn[sr] = function(fn) { return fn ? this.on('resize', debounce(fn)) : this.trigger(sr); };

    })(jQuery, 'smartresize');

    // http://upshots.org/javascript/jquery-test-if-element-is-in-viewport-visible-on-screen#h-o
    $.fn.isOnScreen = function(x, y) {

        if (x == null || typeof x == 'undefined') x = 1;
        if (y == null || typeof y == 'undefined') y = 1;

        var win = $(window);

        var viewport = {
            top: win.scrollTop(),
            left: win.scrollLeft()
        };
        viewport.right = viewport.left + win.width();
        viewport.bottom = viewport.top + win.height();

        var height = this.outerHeight();
        var width = this.outerWidth();

        if (!width || !height) {
            return false;
        }

        var bounds = this.offset();
        bounds.right = bounds.left + width;
        bounds.bottom = bounds.top + height;

        var visible = (!(viewport.right < bounds.left || viewport.left > bounds.right || viewport.bottom < bounds.top || viewport.top > bounds.bottom));

        if (!visible) {
            return false;
        }

        var deltas = {
            top: Math.min(1, (bounds.bottom - viewport.top) / height),
            bottom: Math.min(1, (viewport.bottom - bounds.top) / height),
            left: Math.min(1, (bounds.right - viewport.left) / width),
            right: Math.min(1, (viewport.right - bounds.left) / width)
        };

        return (deltas.left * deltas.right) >= x && (deltas.top * deltas.bottom) >= y;
    };

    $.fn.horizontalTabs = function() {

        return this.each(function() {
            var self = this;
            var $elem = $(this);
            var methods = {};

            methods.getArrowsTotalWidth = function() {
                return ($elem.find('.arrow-left').outerWidth() + $elem.find('.arrow-right').outerWidth());
            };

            methods.adjustScroll = function() {
                widthOfList = 0;
                var $items = $elem.find('.nav-tabs-horizontal li:not(.nav-tabs-submenu-child, nav-tabs-submenu-parent)');
                var $active;
                $items.each(function(index, item) {
                    widthOfList += $(item).outerWidth();
                    if ($(item).hasClass("active") && widthOfList > $elem.width()) {
                        $active = $(item);
                    }
                    if ($(item).is(':last-child')) {
                        $lastItem = $(item);
                    }
                });

                widthAvailale = $elem.width();

                if (widthOfList > widthAvailale) {
                    $elem.find('.scroller').show();
                    methods.updateArrowStyle(currentPos);
                    widthOfReducedList = $elem.find('.nav-tabs-horizontal').outerWidth();
                } else {
                    $elem.find('.scroller').hide();
                }
                if ($active) {
                    setTimeout(function() {
                        currentPos = $active.position().left - methods.getArrowsTotalWidth()
                        $elem.find('.nav-tabs-horizontal').animate({
                            scrollLeft: currentPos
                        }, 100);
                    }, 150);
                }
            };

            methods.scrollLeft = function() {
                $elem.find('.nav-tabs-horizontal').animate({
                    scrollLeft: currentPos - widthOfReducedList
                }, 500);

                if (currentPos - widthOfReducedList > 0) {
                    currentPos -= widthOfReducedList;
                } else {
                    currentPos = 0;
                }
            };

            methods.scrollRight = function() {

                $elem.find('.nav-tabs-horizontal').animate({
                    scrollLeft: currentPos + widthOfReducedList
                }, 500);

                if ((currentPos + widthOfReducedList) < (widthOfList - widthOfReducedList)) {
                    currentPos += widthOfReducedList;
                } else {
                    currentPos = (widthOfList - widthOfReducedList);
                }
            };

            methods.manualScroll = function() {
                currentPos = $elem.find('.nav-tabs-horizontal').scrollLeft();

                methods.updateArrowStyle(currentPos);
            };

            methods.updateArrowStyle = function(position) {

                waypointlastItem = new Waypoint({
                    element: $lastItem[0],
                    context: $elem[0],
                    horizontal: true,
                    offset: 'right-in-view',
                    handler: function(direction) {
                        delay(function() {
                            if (direction == 'right' && $lastItem.isOnScreen()) {
                                $elem.find('.arrow-right').addClass('disabled');
                            } else {
                                $elem.find('.arrow-right').removeClass('disabled');
                            }
                        }, 200);
                    }
                });

                if (position <= 0) {
                    $elem.find('.arrow-left').addClass('disabled');
                    setTimeout(function() {
                        $elem.find('.arrow-right').removeClass('disabled');
                    }, 100);
                } else {
                    $elem.find('.arrow-left').removeClass('disabled');
                };
            };

            methods.clearMenuItem = function(menu) {
                $('[data-sub-menu-id="' + menu.attr('data-menu-id') + '"]').remove();
                menu.removeAttr('data-menu-id');
            }

            methods.genUniqueID = function() {
                return Math.random().toString(36).substr(2, 9);
            }

            // Variable creation
            var $lastItem,
                waypointlastItem,
                $subMenuHref = $elem.find('li.nav-tabs-submenu-parent > a'),
                widthOfReducedList = $elem.find('.nav-tabs-horizontal').outerWidth(),
                widthOfList = 0,
                currentPos = 0;

            $(window).smartresize(function(){
                 methods.adjustScroll();
            });

            // Whenever we click a menu item that has a submenu
            if ($subMenuHref.length > 0) {
                $subMenuHref.on('click', function(e) {
                    e.preventDefault();
                    var $menuItem = $(this);

                    if ($menuItem.attr('data-menu-id')) {
                        methods.clearMenuItem($menuItem);
                        return false;
                    }
                    var newID = methods.genUniqueID();
                    $menuItem.attr('data-menu-id', newID);
                    var $submenuWrapper = $menuItem.parents('li.nav-tabs-submenu-parent').find('.tabs-submenu-wrapper');
                    var $clonedSubmenu = $submenuWrapper.clone();
                    // grab the menu item's position relative to its positioned parent
                    var menuItemOffset = $menuItem.offset();
                    // place the submenu in the correct position relevant to the menu item
                    $clonedSubmenu.find('ul').css({
                            top: menuItemOffset.top + $menuItem.outerHeight() - 5,
                            left: menuItemOffset.left,
                            display: 'block',
                            'border-top-left-radius': '0',
                            'border-top-right-radius': '0',
                        })
                        .attr('data-sub-menu-id', newID);
                    $clonedSubmenu.find('ul li.active:eq(0) > a').css({
                        'border-top-left-radius': '0',
                        'border-top-right-radius': '0',
                    });
                    $('body').append($clonedSubmenu.unwrap().html());
                    $('body').on('click', function(e) {
                        if (e.target != $menuItem[0]) {
                            methods.clearMenuItem($menuItem);
                        }
                    });
                });
            }
            $elem.find('.arrow-left').on('click.horizontalTabs', function() {
                if ($(this).hasClass('disabled')) {
                    return false;
                }
                methods.scrollLeft();
            });

            $elem.find('.arrow-right').on('click.horizontalTabs', function() {
                if ($(this).hasClass('disabled')) {
                    return false;
                }
                methods.scrollRight();
            });

            $elem.find('.nav-tabs-horizontal').scroll(function() {
                methods.manualScroll();
            });

            // Initial Call
            methods.adjustScroll();

            return this;
        });
    }

}(window.jQuery));

/**
 * @since 2.3.2
 * This file is compiled with assets/js/common.js because most of the functions can be used in admin and clients area
 */

// For manually modals where no close is defined
$(document).keyup(function (e) {
  if (e.keyCode == 27) {
    // escape key maps to keycode `27`

    // Close modal if only modal is opened and there is no 2 modals opened
    // This will trigger only if there is only 1 modal visible/opened

    if ($(".modal").is(":visible") && $(".modal:visible").length === 1) {
      $("body")
        .find('.modal:visible [onclick^="close_modal_manually"]')
        .eq(0)
        .click();
    }
  }
});

$(function () {
  setTimeout(function () {
    // Remove the left and right resize indicators for gantt
    $("#gantt .noDrag > g.handle-group").hide();

    // Removes the gantt dragging by bar wrapper
    var ganttBarWrappers = document.querySelectorAll(".bar-wrapper");

    Array.prototype.forEach.call(ganttBarWrappers, function (el) {
      el.addEventListener(
        "mousedown",
        function (e, element) {
          if ($(e.target).closest(".bar-wrapper").hasClass("noDrag")) {
            event.stopPropagation();
          }
        },
        true
      );
    });
  }, 1000);

  // + button for adding more attachments
  var addMoreAttachmentsInputKey = 1;
  $("body").on("click", ".add_more_attachments", function () {
    if ($(this).hasClass("disabled")) {
      return false;
    }

    var total_attachments = $('.attachments input[name*="attachments"]').length;
    if ($(this).data("max") && total_attachments >= $(this).data("max")) {
      return false;
    }

    var newattachment = $(".attachments")
      .find(".attachment")
      .eq(0)
      .clone()
      .appendTo(".attachments");
    newattachment.find("input").removeAttr("aria-describedby aria-invalid");
    newattachment
      .find("input")
      .attr("name", "attachments[" + addMoreAttachmentsInputKey + "]")
      .val("");
    newattachment
      .find(
        $.fn.appFormValidator.internal_options.error_element + '[id*="error"]'
      )
      .remove();
    newattachment
      .find("." + $.fn.appFormValidator.internal_options.field_wrapper_class)
      .removeClass(
        $.fn.appFormValidator.internal_options.field_wrapper_error_class
      );
    newattachment.find("i").removeClass("fa-plus").addClass("fa-minus");
    newattachment
      .find("button")
      .removeClass("add_more_attachments")
      .addClass("remove_attachment")
      .removeClass("btn-success")
      .removeClass("btn-default")
      .addClass("btn-danger");
    addMoreAttachmentsInputKey++;
  });

  // Remove attachment
  $("body").on("click", ".remove_attachment", function () {
    $(this).parents(".attachment").remove();
  });

  $("a[href='#top']").on("click", function (e) {
    e.preventDefault();
    $("html,body").animate({ scrollTop: 0 }, 1000);
    e.preventDefault();
  });

  $("a[href='#bot']").on("click", function (e) {
    e.preventDefault();
    $("html,body").animate({ scrollTop: $(document).height() }, 1000);
    e.preventDefault();
  });

  // Jump to page feature
  $(document).on("change", ".dt-page-jump-select", function () {
    $("#" + $(this).attr("data-id"))
      .DataTable()
      .page($(this).val() - 1)
      .draw(false);
  });

  // Remove tooltip fix on body click (in case user clicked link and tooltip stays open)
  $("body").on("click", function () {
    $(".tooltip").remove();
  });

  // Show please wait text on button where data-loading-text is added
  $("body").on("click", "[data-loading-text]", function () {
    var form = $(this).data("form");
    if (form !== null && typeof form != "undefined") {
      // Handled in form submit handler function
      return true;
    } else {
      $(this).button("loading");
    }
  });

  // Close all popovers if user click on body and the click is not inside the popover content area
  $("body").on("click", function (e) {
    $('[data-toggle="popover"],.manual-popover').each(function () {
      //the 'is' for buttons that trigger popups
      //the 'has' for icons within a button that triggers a popup
      if (
        !$(this).is(e.target) &&
        $(this).has(e.target).length === 0 &&
        $(".popover").has(e.target).length === 0
      ) {
        $(this).popover("hide");
      }
    });
  });

  $("body").on("change", 'select[name="range"]', function () {
    var $period = $(".period");
    if ($(this).val() == "period") {
      $period.removeClass("hide");
    } else {
      $period.addClass("hide");
      $period.find("input").val("");
    }
  });

  $(document).on("shown.bs.dropdown", ".table-responsive", function (e) {
    var $container = $(e.target);
    if ($container.hasClass("bootstrap-select")) {
      return;
    }
    var $dropdown = $container.find(".dropdown-menu");
    if ($dropdown.length) {
      $container.data("dropdown-menu", $dropdown);
    } else {
      $dropdown = $container.data("dropdown-menu");
    }

    $dropdown.css(
      "top",
      $container.offset().top + $container.outerHeight() + "px"
    );
    var leftPosition = 0;
    $dropdown.css("display", "block");
    $dropdown.css("position", "absolute");
    var parentWidth = $container.parent().outerWidth();
    var dropdownWidth = $dropdown.outerWidth();
    leftPosition =
      $container.parent().offset().left - (dropdownWidth - parentWidth);
    $dropdown.css("left", leftPosition + "px");
    $dropdown.css("right", "auto");

    $dropdown.appendTo("body");
  });

  $(document).on("hide.bs.dropdown", ".table-responsive", function (e) {
    var $container = $(e.target);

    if ($container.hasClass("bootstrap-select")) {
      return;
    }
    $container.data("dropdown-menu").css("display", "none");
  });

  // Add are you sure on all delete links (onclick is not handler here)
  $("body").on("click", "._delete", function (e) {
    if (confirm_delete()) {
      return true;
    }
    return false;
  });
});

// Will give alert to confirm delete
function confirm_delete() {
  var message = "Are you sure you want to perform this action?";

  // Clients area
  if (typeof app != "undefined") {
    message = app.lang.confirm_action_prompt;
  }

  var r = confirm(message);
  if (r == false) {
    return false;
  }
  return true;
}

// Delay function
var delay = (function () {
  var timer = 0;
  return function (callback, ms) {
    clearTimeout(timer);
    timer = setTimeout(callback, ms);
  };
})();

$.fn.isInViewport = function () {
  var elementTop = $(this).offset().top;
  var elementBottom = elementTop + $(this).outerHeight();
  var viewportTop = $(window).scrollTop();
  var viewportBottom = viewportTop + $(window).height();
  return elementBottom > viewportTop && elementTop < viewportBottom;
};

String.prototype.matchAll = function (regexp) {
  var matches = [];
  this.replace(regexp, function () {
    var arr = [].slice.call(arguments, 0);
    var extras = arr.splice(-2);
    arr.index = extras[0];
    arr.input = extras[1];
    matches.push(arr);
  });
  return matches.length ? matches : null;
};

// Function to slug string
function slugify(string) {
  return string
    .toString()
    .trim()
    .toLowerCase()
    .replace(/\s+/g, "-")
    .replace(/[^\w\-]+/g, "")
    .replace(/\-\-+/g, "-")
    .replace(/^-+/, "")
    .replace(/-+$/, "");
}

// Strip html from string
function stripTags(html) {
  var tmp = document.createElement("DIV");
  tmp.innerHTML = html;
  return tmp.textContent || tmp.innerText || "";
}

// Check if field is empty
function empty(data) {
  if (typeof data == "number" || typeof data == "boolean") {
    return false;
  }
  if (typeof data == "undefined" || data === null) {
    return true;
  }
  if (typeof data.length != "undefined") {
    return data.length === 0;
  }
  var count = 0;
  for (var i in data) {
    if (data.hasOwnProperty(i)) {
      count++;
    }
  }
  return count === 0;
}

// Attached new hotkey handler
function add_hotkey(key, func) {
  if (typeof $.Shortcuts == "undefined") {
    return false;
  }

  $.Shortcuts.add({
    type: "down",
    mask: key,
    handler: func,
  });
}

function _tinymce_mobile_toolbar() {
  return [
    "undo",
    "redo",
    "styleselect",
    "bold",
    "italic",
    "link",
    "image",
    "bullist",
    "numlist",
    "forecolor",
    "fontsizeselect",
  ];
}

// Function that convert decimal logged time to HH:MM format
function decimalToHM(decimal) {
  var hrs = parseInt(Number(decimal));
  var min = Math.round((Number(decimal) - hrs) * 60);
  return (hrs < 10 ? "0" + hrs : hrs) + ":" + (min < 10 ? "0" + min : min);
}

// Generate color rgb
function color(r, g, b) {
  return "rgb(" + r + "," + g + "," + b + ")";
}

// Url builder function with parameteres
function buildUrl(url, parameters) {
  var qs = "";
  for (var key in parameters) {
    var value = parameters[key];
    qs += encodeURIComponent(key) + "=" + encodeURIComponent(value) + "&";
  }
  if (qs.length > 0) {
    qs = qs.substring(0, qs.length - 1); //chop off last "&"
    url = url + "?" + qs;
  }
  return url;
}

// Check if is ios Device
function is_ios() {
  return /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
}

// Check if is Microsoft Browser, Internet Explorer 10 od order, Internet Explorer 11 or Edge (any version)
function is_ms_browser() {
  if (
    /MSIE/i.test(navigator.userAgent) ||
    !!navigator.userAgent.match(/Trident.*rv\:11\./)
  ) {
    // this is internet explorer 10
    return true;
  }

  if (/Edge/i.test(navigator.userAgent)) {
    // this is Microsoft Edge
    return true;
  }

  return false;
}

function _simple_editor_config() {
  return {
    forced_root_block: "p",
    height: !is_mobile() ? 100 : 50,
    menubar: false,
    autoresize_bottom_margin: 15,
    plugins: [
      "table advlist codesample autosave" +
        (!is_mobile() ? " autoresize " : " ") +
        "lists link image textcolor media contextmenu paste",
    ],
    toolbar:
      "insert formatselect bold forecolor backcolor" +
      (is_mobile() ? " | " : " ") +
      "alignleft aligncenter alignright bullist numlist | restoredraft",
    insert_button_items: "image media link codesample",
    toolbar1: "",
  };
}

function _create_print_window(name) {
  var params = "width=" + screen.width;
  params += ", height=" + screen.height;
  params += ", top=0, left=0";
  params += ", fullscreen=yes";

  return window.open("", name, params);
}

function _add_print_window_default_styles(mywindow) {
  mywindow.document.write("<style>");
  mywindow.document.write(
    ".clearfix:after { " +
      "clear: both;" +
      "}" +
      ".clearfix:before, .clearfix:after { " +
      'display: table; content: " ";' +
      "}" +
      "body { " +
      "font-family: Arial, Helvetica, sans-serif;color: #444; font-size:13px;" +
      "}" +
      ".bold { " +
      "font-weight: bold !important;" +
      "}" +
      ""
  );

  mywindow.document.write("</style>");
}

// Equivalent function like php nl2br
function nl2br(str, is_xhtml) {
  var breakTag =
    is_xhtml || typeof is_xhtml === "undefined" ? "<br />" : "<br>";
  return (str + "").replace(
    /([^>\r\n]?)(\r\n|\n\r|\r|\n)/g,
    "$1" + breakTag + "$2"
  );
}

// Kanban til direction
function tilt_direction(item) {
  setTimeout(function () {
    var left_pos = item.position().left,
      move_handler = function (e) {
        if (e.pageX >= left_pos) {
          item.addClass("right");
          item.removeClass("left");
        } else {
          item.addClass("left");
          item.removeClass("right");
        }
        left_pos = e.pageX;
      };
    $("html").on("mousemove", move_handler);
    item.data("move_handler", move_handler);
  }, 1000);
}

// Function to close modal manually... needed in some modals where the data is flexible.
function close_modal_manually(modal) {
  modal = $(modal).length === 0 ? $("body").find(modal) : (modal = $(modal));
  modal.fadeOut("fast", function () {
    modal.remove();
    if (!$("body").find(".modal").is(":visible")) {
      $(".modal-backdrop").remove();
      $("body").removeClass("modal-open");
    }
  });
}

// Show password on hidden input field
function showPassword(name) {
  var target = $('input[name="' + name + '"]');
  if ($(target).attr("type") == "password" && $(target).val() !== "") {
    $(target).queue(function () {
      $(target).attr("type", "text").dequeue();
    });
  } else {
    $(target).queue(function () {
      $(target).attr("type", "password").dequeue();
    });
  }
}

// Generate hidden input field
function hidden_input(name, val) {
  return '<input type="hidden" name="' + name + '" value="' + val + '">';
}

// Init color pickers
function appColorPicker(element) {
  if (typeof element == "undefined") {
    element = $("body").find("div.colorpicker-input");
  }
  if (element.length) {
    element.colorpicker({
      format: "hex",
    });
  }
}

// Init bootstrap select picker
function appSelectPicker(element) {
  if (typeof element == "undefined") {
    element = $("body").find("select.selectpicker");
  }

  if (element.length) {
    element.selectpicker({
      showSubtext: true,
    });
  }
}

// Progress bar animation load
function appProgressBar() {
  var progress_bars = $("body").find(".progress div.progress-bar");
  if (progress_bars.length) {
    progress_bars.each(function () {
      var bar = $(this);
      var perc = bar.attr("data-percent");
      bar.css("width", perc + "%");
      if (!bar.hasClass("no-percent-text")) {
        bar.text(perc + "%");
      }
    });
  }
}

// Lightbox plugins for images
function appLightbox(options) {
  if (typeof lightbox == "undefined") {
    return false;
  }

  var _lightBoxOptions = {
    showImageNumberLabel: false,
    resizeDuration: 200,
    positionFromTop: 25,
  };

  if (typeof options != "undefined") {
    jQuery.extend(_lightBoxOptions, options);
  }

  lightbox.option(_lightBoxOptions);
}

// Datatables inline/offline lazy load images
function DataTablesInlineLazyLoadImages(nRow, aData, iDisplayIndex) {
  var img = $("img.img-table-loading", nRow);
  img.attr("src", img.data("orig"));
  img.prev("div").addClass("hide");
  return nRow;
}

// Datatables custom job to page function
function _table_jump_to_page(table, oSettings) {
  var paginationData = table.DataTable().page.info();
  var previousDtPageJump = $("body").find(
    "#dt-page-jump-" + oSettings.sTableId
  );

  if (previousDtPageJump.length) {
    previousDtPageJump.remove();
  }

  if (paginationData.pages > 1) {
    var jumpToPageSelect = $("<select></select>", {
      "data-id": oSettings.sTableId,
      class: "dt-page-jump-select form-control",
      id: "dt-page-jump-" + oSettings.sTableId,
    });

    var paginationHtml = "";

    for (var i = 1; i <= paginationData.pages; i++) {
      var selectedCurrentPage = paginationData.page + 1 === i ? "selected" : "";
      paginationHtml +=
        "<option value='" +
        i +
        "'" +
        selectedCurrentPage +
        ">" +
        i +
        "</option>";
    }

    if (paginationHtml != "") {
      jumpToPageSelect.append(paginationHtml);
    }

    $("#" + oSettings.sTableId + "_wrapper .dt-page-jump").append(
      jumpToPageSelect
    );
  }
}

// Generate float alert
function alert_float(type, message, timeout) {
  var aId, el;

  aId = $("body").find("float-alert").length;
  aId++;

  aId = "alert_float_" + aId;

  el = $("<div></div>", {
    id: aId,
    class:
      "float-alert animated fadeInRight col-xs-10 col-sm-3 alert alert-" + type,
  });

  el.append(
    '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'
  );
  el.append('<span class="fa-regular fa-bell" data-notify="icon"></span>');
  el.append('<span class="alert-title">' + message + "</span>");

  $("body").append(el);
  timeout = timeout ? timeout : 3500;
  setTimeout(function () {
    $("#" + aId).hide("fast", function () {
      $("#" + aId).remove();
    });
  }, timeout);
}

// Generate random password
function generatePassword(field) {
  var length = 12,
    charset = "abcdefghijklnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789",
    retVal = "";
  for (var i = 0, n = charset.length; i < length; ++i) {
    retVal += charset.charAt(Math.floor(Math.random() * n));
  }
  $(field).parents().find("input.password").val(retVal);
}

// Get url params like $_GET
function get_url_param(param) {
  var vars = {};
  window.location.href.replace(location.hash, "").replace(
    /[?&]+([^=&]+)=?([^&]*)?/gi, // regexp
    function (m, key, value) {
      // callback
      vars[key] = value !== undefined ? value : "";
    }
  );
  if (param) {
    return vars[param] ? vars[param] : null;
  }
  return vars;
}

// Is mobile checker javascript
function is_mobile() {
  if (typeof app != "undefined" && typeof app.is_mobile != "undefined") {
    return app.is_mobile;
  }

  try {
    document.createEvent("TouchEvent");
    return true;
  } catch (e) {
    return false;
  }
}

function onGoogleApiLoad() {
  var pickers = $(".gpicker");
  $.each(pickers, function () {
    var that = $(this);
    setTimeout(function () {
      that.googleDrivePicker();
    }, 10);
  });
}

function _get_jquery_comments_default_config(discussions_lang) {
  return {
    roundProfilePictures: true,
    textareaRows: 4,
    textareaRowsOnFocus: 6,
    profilePictureURL: discussion_user_profile_image_url,
    enableUpvoting: false,
    enableDeletingCommentWithReplies: false,
    enableAttachments: true,
    popularText: "",
    enableDeleting: true,
    textareaPlaceholderText: discussions_lang.discussion_add_comment,
    newestText: discussions_lang.discussion_newest,
    oldestText: discussions_lang.discussion_oldest,
    attachmentsText: discussions_lang.discussion_attachments,
    sendText: discussions_lang.discussion_send,
    replyText: discussions_lang.discussion_reply,
    editText: discussions_lang.discussion_edit,
    editedText: discussions_lang.discussion_edited,
    youText: discussions_lang.discussion_you,
    saveText: discussions_lang.discussion_save,
    deleteText: discussions_lang.discussion_delete,
    viewAllRepliesText:
      discussions_lang.discussion_view_all_replies + " (__replyCount__)",
    hideRepliesText: discussions_lang.discussion_hide_replies,
    noCommentsText: discussions_lang.discussion_no_comments,
    noAttachmentsText: discussions_lang.discussion_no_attachments,
    attachmentDropText: discussions_lang.discussion_attachments_drop,
    timeFormatter: function (time) {
      return moment(time).fromNow();
    },
  };
}

function appDataTableInline(element, options) {
  var selector = typeof element !== "undefined" ? element : ".dt-table";
  var $tables = $(selector);

  if ($tables.length === 0) {
    return;
  }

  var defaults = {
    supportsButtons: false,
    supportsLoading: false,
    dtLengthMenuAllText: app.lang.dt_length_menu_all,
    processing: true,
    language: app.lang.datatables,
    paginate: true,
    pageLength: app.options.tables_pagination_limit,
    fnRowCallback: DataTablesInlineLazyLoadImages,
    order: [0, "asc"],
    dom: "<'row'><'row'<'col-md-6'lB><'col-md-6'f>r>t<'row'<'col-md-4'i><'col-md-8 dataTables_paging'<'#colvis'><'.dt-page-jump'>p>>",
    fnDrawCallback: function (oSettings) {
      _table_jump_to_page(this, oSettings);

      if (oSettings.aoData.length == 0 || oSettings.aiDisplay.length == 0) {
        $(oSettings.nTableWrapper).addClass("app_dt_empty");
      } else {
        $(oSettings.nTableWrapper).removeClass("app_dt_empty");
      }

      if (typeof settings.onDrawCallback == "function") {
        settings.onDrawCallback(oSettings, this);
      }
    },
    initComplete: function (oSettings, json) {
      this.wrap('<div class="table-responsive"></div>');

      var dtInlineEmpty = this.find(".dataTables_empty");
      if (dtInlineEmpty.length) {
        dtInlineEmpty.attr("colspan", this.find("thead th").length);
      }

      if (settings.supportsLoading) {
        this.parents(".table-loading").removeClass("table-loading");
      }

      if (settings.supportsButtons) {
        var thLastChild = $tables.find("thead th:last-child");

        if (thLastChild.hasClass("options")) {
          thLastChild.addClass("not-export");
        }

        var thLastChild = $tables.find("thead th:last-child");
        if (
          typeof app != "undefined" &&
          thLastChild.text().trim() == app.lang.options
        ) {
          thLastChild.addClass("not-export");
        }

        var thFirstChild = $tables.find("thead th:first-child");
        if (thFirstChild.find('input[type="checkbox"]').length > 0) {
          thFirstChild.addClass("not-export");
        }

        if (typeof settings.onInitComplete == "function") {
          settings.onInitComplete(oSettings, json, this);
        }
      }
    },
  };

  var settings = $.extend({}, defaults, options);
  var length_options = [10, 25, 50, 100];
  var length_options_names = [10, 25, 50, 100];

  settings.pageLength = parseFloat(settings.pageLength);

  if ($.inArray(settings.pageLength, length_options) == -1) {
    length_options.push(settings.pageLength);
    length_options_names.push(settings.pageLength);
  }

  length_options.sort(function (a, b) {
    return a - b;
  });

  length_options_names.sort(function (a, b) {
    return a - b;
  });

  length_options.push(-1);
  length_options_names.push(settings.dtLengthMenuAllText);

  var orderCol, orderType, sTypeColumns;
  settings.lengthMenu = [length_options, length_options_names];

  if (!settings.supportsButtons) {
    settings.dom = settings.dom.replace("lB", "l");
  }

  $.each($tables, function () {
    $(this).addClass("dt-inline");

    orderCol = $(this).attr("data-order-col");
    orderType = $(this).attr("data-order-type");
    sTypeColumns = $(this).attr("data-s-type");

    if (orderCol && orderType) {
      settings.order = [[orderCol, orderType]];
    }

    if (sTypeColumns) {
      sTypeColumns = JSON.parse(sTypeColumns);
      var columns = $(this).find("thead th");
      var totalColumns = columns.length;
      settings.aoColumns = [];
      for (var i = 0; i < totalColumns; i++) {
        var column = $(columns[i]);
        var sTypeColumnOption = sTypeColumns.find(function (v) {
          return v["column"] === column.index();
        });
        settings.aoColumns.push(
          sTypeColumnOption ? { sType: sTypeColumnOption.type } : null
        );
      }
    }

    if (settings.supportsButtons) {
      settings.buttons = get_datatable_buttons(this);
    }

    $(this).DataTable(settings);
  });
}

// Returns datatbles export button array based on settings
// Admin area only
function get_datatable_buttons(table) {
  // pdfmake arabic fonts support
  if (
    app.user_language.toLowerCase() == "persian" ||
    app.user_language.toLowerCase() == "arabic"
  ) {
    if ($("body").find("#amiri").length === 0) {
      var mainjs = document.createElement("script");
      mainjs.setAttribute(
        "src",
        "https://rawgit.com/xErik/pdfmake-fonts-google/master/build/script/ofl/amiri.js"
      );
      mainjs.setAttribute("id", "amiri");
      document.head.appendChild(mainjs);

      var mapjs = document.createElement("script");
      mapjs.setAttribute(
        "src",
        "https://rawgit.com/xErik/pdfmake-fonts-google/master/build/script/ofl/amiri.map.js"
      );
      document.head.appendChild(mapjs);
    }
  }

  var formatExport = {
    body: function (data, row, column, node) {
      // Fix for notes inline datatables
      // Causing issues because of the hidden textarea for edit and the content is duplicating
      // This logic may be extended in future for other similar fixes
      var newTmpRow = $("<div></div>", data);
      newTmpRow.append(data);

      if (newTmpRow.find("[data-note-edit-textarea]").length > 0) {
        newTmpRow.find("[data-note-edit-textarea]").remove();
        data = newTmpRow.html().trim();
      }
      // Convert e.q. two months ago to actual date
      var exportTextHasActionDate = newTmpRow.find(".text-has-action.is-date");

      if (exportTextHasActionDate.length) {
        data = exportTextHasActionDate.attr("data-title");
      }

      if (newTmpRow.find(".row-options").length > 0) {
        newTmpRow.find(".row-options").remove();
        data = newTmpRow.html().trim();
      }

      if (newTmpRow.find(".table-export-exclude").length > 0) {
        newTmpRow.find(".table-export-exclude").remove();
        data = newTmpRow.html().trim();
      }

      if (data) {
        /*       // 300,00 becomes 300.00 because excel does not support decimal as coma
                var regexFixExcelExport = new RegExp("([0-9]{1,3})(,)([0-9]{" + app.options.decimal_places + ',' + app.options.decimal_places + "})", "gm");
                // Convert to string because matchAll won't work on integers in case datatables convert the text to integer
                var _stringData = data.toString();
                var found = _stringData.matchAll(regexFixExcelExport);
                if (found) {
                    data = data.replace(regexFixExcelExport, "$1.$3");
                }*/
      }

      // Datatables use the same implementation to strip the html.
      var div = document.createElement("div");
      div.innerHTML = data;
      var text = div.textContent || div.innerText || "";

      return text.trim();
    },
  };
  var table_buttons_options = [];

  if (
    typeof table_export_button_is_hidden != "function" ||
    !table_export_button_is_hidden()
  ) {
    table_buttons_options.push({
      extend: "collection",
      text: app.lang.dt_button_export,
      className: "btn btn-sm btn-default-dt-options",
      buttons: [
        {
          extend: "excel",
          text: app.lang.dt_button_excel,
          footer: true,
          exportOptions: {
            columns: [":not(.not-export)"],
            rows: function (index) {
              return _dt_maybe_export_only_selected_rows(index, table);
            },
            format: formatExport,
          },
        },
        {
          extend: "csvHtml5",
          text: app.lang.dt_button_csv,
          footer: true,
          exportOptions: {
            columns: [":not(.not-export)"],
            rows: function (index) {
              return _dt_maybe_export_only_selected_rows(index, table);
            },
            format: formatExport,
          },
        },
        {
          extend: "pdfHtml5",
          text: app.lang.dt_button_pdf,
          footer: true,
          exportOptions: {
            columns: [":not(.not-export)"],
            rows: function (index) {
              return _dt_maybe_export_only_selected_rows(index, table);
            },
            format: formatExport,
          },
          orientation: "landscape",
          customize: function (doc) {
            // Fix for column widths
            var table_api = $(table).DataTable();
            var columns = table_api.columns().visible();
            var columns_total = columns.length;
            var total_visible_columns = 0;

            for (i = 0; i < columns_total; i++) {
              // Is only visible column
              if (columns[i] == true) {
                total_visible_columns++;
              }
            }

            setTimeout(function () {
              if (total_visible_columns <= 5) {
                var pdf_widths = [];
                for (i = 0; i < total_visible_columns; i++) {
                  pdf_widths.push(735 / total_visible_columns);
                }

                doc.content[1].table.widths = pdf_widths;
              }
            }, 10);

            if (
              app.user_language.toLowerCase() == "persian" ||
              app.user_language.toLowerCase() == "arabic"
            ) {
              doc.defaultStyle.font = Object.keys(pdfMake.fonts)[0];
            }

            doc.styles.tableHeader.alignment = "left";
            doc.defaultStyle.fontSize = 10;

            doc.styles.tableHeader.fontSize = 10;
            doc.styles.tableHeader.margin = [3, 3, 3, 3];

            doc.styles.tableFooter.fontSize = 10;
            doc.styles.tableFooter.margin = [3, 0, 0, 0];

            doc.pageMargins = [2, 20, 2, 20];
          },
        },
        {
          extend: "print",
          text: app.lang.dt_button_print,
          footer: true,
          exportOptions: {
            columns: [":not(.not-export)"],
            rows: function (index) {
              return _dt_maybe_export_only_selected_rows(index, table);
            },
            format: formatExport,
          },
        },
      ],
    });
  }
  var tableButtons = $("body").find(".table-btn");

  $.each(tableButtons, function () {
    var b = $(this);
    if (b.length && b.attr("data-table")) {
      if ($(table).is(b.attr("data-table"))) {
        table_buttons_options.push({
          text: b.text().trim(),
          className: "btn btn-sm btn-default-dt-options",
          action: function (e, dt, node, config) {
            b.click();
          },
        });
      }
    }
  });

  if (!$(table).hasClass("dt-inline")) {
    table_buttons_options.push({
      text: '<i class="fa fa-refresh"></i>',
      className: "btn btn-sm btn-default-dt-options btn-dt-reload",
      action: function (e, dt, node, config) {
        dt.ajax.reload();
      },
    });
  }

  // TODO
  // console.log

  /*   if ($(table).hasClass('customizable-table')) {
            table_buttons_options.push({
                columns: '.toggleable',
                text: '<i class="fa fa-cog"></i>',
                extend: 'colvis',
                className: 'btn btn-default-dt-options dt-column-visibility',
            });
        }*/

  return table_buttons_options;
}

// Check if table export button should be hidden based on settings
// Admin area only
function table_export_button_is_hidden() {
  if (app.options.show_table_export_button != "to_all") {
    if (
      app.options.show_table_export_button === "hide" ||
      (app.options.show_table_export_button === "only_admins" &&
        app.user_is_admin == 0)
    ) {
      return true;
    }
  }
  return false;
}

function _dt_maybe_export_only_selected_rows(index, table) {
  table = $(table);
  index = index.toString();
  var bulkActionsCheckbox = table.find('thead th input[type="checkbox"]').eq(0);
  if (bulkActionsCheckbox && bulkActionsCheckbox.length > 0) {
    var rows = table.find("tbody tr");
    var anyChecked = false;
    $.each(rows, function () {
      if ($(this).find('td:first input[type="checkbox"]:checked').length) {
        anyChecked = true;
      }
    });

    if (anyChecked) {
      if (
        table.find(
          "tbody tr:eq(" + index + ') td:first input[type="checkbox"]:checked'
        ).length > 0
      ) {
        return index;
      } else {
        return null;
      }
    } else {
      return index;
    }
  }
  return index;
}

// Slide toggle any selector passed
function slideToggle(selector, callback) {
  var $element = $(selector);
  if ($element.hasClass("hide")) {
    $element.removeClass("hide", "slow");
  }
  if ($element.length) {
    $element.slideToggle();
  }
  // Set all progress bar to 0 percent
  var progress_bars = $(".progress-bar").not(".not-dynamic");
  if (progress_bars.length > 0) {
    progress_bars.each(function () {
      $(this).css("width", 0 + "%");
      $(this).text(0 + "%");
    });
    // Init the progress bars again
    if (typeof appProgressBar == "function") {
      appProgressBar();
    }
  }
  // Possible callback after slide toggle
  if (typeof callback == "function") {
    callback();
  }
}

// Date picker init, options and optionally element
function appDatepicker(options) {
  if (typeof app._date_picker_locale_configured === "undefined") {
    jQuery.datetimepicker.setLocale(app.locale);
    app._date_picker_locale_configured = true;
  }

  var defaults = {
    date_format: app.options.date_format,
    time_format: app.options.time_format,
    week_start: app.options.calendar_first_day,
    date_picker_selector: ".datepicker",
    date_time_picker_selector: ".datetimepicker",
  };

  var settings = $.extend({}, defaults, options);

  var datepickers =
    typeof settings.element_date != "undefined"
      ? settings.element_date
      : $(settings.date_picker_selector);
  var datetimepickers =
    typeof settings.element_time != "undefined"
      ? settings.element_time
      : $(settings.date_time_picker_selector);

  if (datetimepickers.length === 0 && datepickers.length === 0) {
    return;
  }

  // Datepicker without time
  $.each(datepickers, function () {
    var that = $(this);

    var opt = {
      timepicker: false,
      scrollInput: false,
      lazyInit: true,
      format: settings.date_format,
      dayOfWeekStart: settings.week_start,
    };

    // Check in case the input have date-end-date or date-min-date
    var max_date = that.attr("data-date-end-date");
    var min_date = that.attr("data-date-min-date");
    var lazy = that.attr("data-lazy");

    if (lazy) {
      opt.lazyInit = lazy == "true";
    }

    if (max_date) {
      opt.maxDate = max_date;
    }

    if (min_date) {
      opt.minDate = min_date;
    }

    // Init the picker
    that.datetimepicker(opt);

    that
      .parents(".form-group")
      .find(".calendar-icon")
      .on("click", function () {
        that.focus();
        that.trigger("open.xdsoft");
      });
  });

  // Datepicker with time
  $.each(datetimepickers, function () {
    var that = $(this);
    var opt_time = {
      lazyInit: true,
      scrollInput: false,
      validateOnBlur: false,
      dayOfWeekStart: settings.week_start,
    };
    if (settings.time_format == 24) {
      opt_time.format = settings.date_format + " H:i";
    } else {
      opt_time.format = settings.date_format + " g:i A";
      opt_time.formatTime = "g:i A";
    }
    // Check in case the input have date-end-date or date-min-date
    var max_date = that.attr("data-date-end-date");
    var min_date = that.attr("data-date-min-date");
    var step = that.attr("data-step");
    var lazy = that.attr("data-lazy");

    if (lazy) {
      opt_time.lazyInit = lazy == "true";
    }

    if (step) {
      opt_time.step = parseInt(step);
    }

    if (max_date) {
      opt_time.maxDate = max_date;
    }

    if (min_date) {
      opt_time.minDate = min_date;
    }
    // Init the picker
    that.datetimepicker(opt_time);

    that
      .parents(".form-group")
      .find(".calendar-icon")
      .on("click", function () {
        that.focus();
        that.trigger("open.xdsoft");
      });
  });
}

function appTagsInput(element) {
  if (typeof element == "undefined") {
    element = $("body").find("input.tagsinput");
  }

  if (element.length) {
    element.tagit({
      availableTags: app.available_tags,
      allowSpaces: true,
      animate: false,
      placeholderText: app.lang.tag,
      showAutocompleteOnFocus: true,
      caseSensitive: false,
      autocomplete: {
        appendTo: "#inputTagsWrapper",
      },
      afterTagAdded: function (event, ui) {
        var tagIndexAvailable = app.available_tags.indexOf(
          $.trim($(ui.tag).find(".tagit-label").text())
        );
        if (tagIndexAvailable > -1) {
          var _tagId = app.available_tags_ids[tagIndexAvailable];
          $(ui.tag).addClass("tag-id-" + _tagId);
        }
        showHideTagsPlaceholder($(this));
      },
      afterTagRemoved: function (event, ui) {
        showHideTagsPlaceholder($(this));
      },
    });
  }
}
// Fix for reordering the items the tables to show the full width
function fixHelperTableHelperSortable(e, ui) {
  ui.children().each(function () {
    $(this).width($(this).width());
  });
  return ui;
}

// Predefined and default dropzone plugin options
function _dropzone_defaults() {
  var acceptedFiles = app.options.allowed_files;

  // https://discussions.apple.com/thread/7229860
  if (
    app.browser === "safari" &&
    acceptedFiles.indexOf(".jpg") > -1 &&
    acceptedFiles.indexOf(".jpeg") === -1
  ) {
    acceptedFiles += ",.jpeg";
  }

  return {
    createImageThumbnails: true,
    dictDefaultMessage: app.lang.drop_files_here_to_upload,
    dictFallbackMessage: app.lang.browser_not_support_drag_and_drop,
    dictFileTooBig: app.lang.file_exceeds_maxfile_size_in_form,
    dictCancelUpload: app.lang.cancel_upload,
    dictRemoveFile: app.lang.remove_file,
    dictMaxFilesExceeded: app.lang.you_can_not_upload_any_more_files,
    maxFilesize: (app.max_php_ini_upload_size_bytes / (1024 * 1024)).toFixed(0),
    acceptedFiles: acceptedFiles,
    error: function (file, response) {
      alert_float("danger", response);
    },
    complete: function (file) {
      this.files.length && this.removeFile(file);
    },
  };
}

function appCreateDropzoneOptions(options) {
  return $.extend({}, _dropzone_defaults(), options);
}

function onChartClickRedirect(evt, chart, fetchUrl) {
  if (typeof fetchUrl == "undefined") {
    fetchUrl = "statusLink";
  }
  var item = chart.getElementAtEvent(evt)[0];
  if (item) {
    var link = chart.data.datasets[0][fetchUrl][item["_index"]];
    if (link) {
      window.location.href = link;
    }
  }
}

// Clear memory leak
// Only use it if all libraries are included
function destroy_dynamic_scripts_in_element(element) {
  element
    .find("input.tagsinput")
    .tagit("destroy")
    .find(".manual-popover")
    .popover("destroy")
    .find(".datepicker")
    .datetimepicker("destroy")
    .find("select")
    .selectpicker("destroy");
}

// Old validate form function, callback to _validate_form
// You should use only $(form).appFormValidator();
function appValidateForm(form, form_rules, submithandler, overwriteMessages) {
  $(form).appFormValidator({
    rules: form_rules,
    onSubmit: submithandler,
    messages: overwriteMessages,
  });
}

function htmlEntities(str) {
  return String(str)
    .replace(/&/g, "&amp;")
    .replace(/</g, "&lt;")
    .replace(/>/g, "&gt;")
    .replace(/"/g, "&quot;");
}
