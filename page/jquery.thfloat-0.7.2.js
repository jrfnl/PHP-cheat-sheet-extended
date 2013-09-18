/**
 * v0.7.2 THFloat plugin for jQuery
 * http://rommelsantor.com/jquery/thfloat
 *
 * Author(s): Rommel Santor
 *            http://rommelsantor.com
 *
 * This plugin allows you to float a table's <thead> or <tfoot> keeping it
 * in view when it would normally be scrolled out of view.
 *
 * Copyright (c) 2011 by Rommel Santor <rommel at rommelsantor dot com>
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
@*/
/**
 * >> Description <<
 *  The THFloat plugin for jQuery allows you to automatically float (or affix)
 *  either a given table's <thead>, <tfoot>, or both at the top or bottom of a
 *  scrolling container parent/ancestor so that they stay in view even though
 *  the table's <tbody> contents have been scrolled out of the visible area.
 *
 *  This was developed and is very handy for long data tables with many columns,
 *  as it allows users to always know which column contains which value without
 *  the column header row having to be included repeatedly throughout the table
 *  (this is often the typical solution).
 *
 * >> Requirements <<
 *  jQuery v1.4 or better
 *
 * >> Version History <<
 *  Ver 0.7.2 - 2013-08-15 - Rommel Santor
 *              Replace CSS copy method with much better code by Mike Dunn. Thanks
 *              to Koos van der Kolk for suggesting it!
 *  Ver 0.7 - 2013-06-28 - Rommel Santor
 *              Modified selection of child <tr> elements of thead/tfoot so only
 *              immediate children are selected; problem was reported by Lucio Iacolettig
 *              when a child table was contained within the thead/tfoot of a thfloat table
 *  Ver 0.6 - 2013-04-11 - Rommel Santor
 *              Reimplementing jQuery.browser if it's not available (it was removed
 *              in jQuery v1.9)
 *  Ver 0.5 - 2012-08-10 - Rommel Santor
 *              Added 'noprint' option to hide floating block when page is printed.
 *              Thanks again to Daniel Gomez for spotting the need for that.
 *  Ver 0.4 - 2012-08-09 - Rommel Santor
 *              Daniel Gomez pointed out that when applying thfloat to multiple
 *              tables on a page and multiple don't have an ID attribute, the
 *              plugin fails. This bug is now fixed.
 *  Ver 0.2 - 2011-04-14 - Rommel Santor
 *              Added 'resize' method and made initial resize automatic; also
 *              cleaned up how the floater is sized when scrolling to stay in
 *              sync with the real table; removed widthOffset as it made the
 *              floater look off most of the time
 *  Ver 0.1.1 - 2011-03-07 - Rommel Santor
 *              Fixed "return;" bug in init()
 *  Ver 0.1 - 2011-03-01 - Rommel Santor
 *            Initial Release
 *
 * >> Tested <<
 *  Mozilla (Firefox 3+)
 *  Webkit (Chrome 9+, Safari for Windows 5+)
 *  MSIE 7, 8, 9
 *  Opera 11+
 *
 * >> Known issues <<
 *  - Safari for Mac apparently has some issues with table resizing; thanks to
 *    Adi Fairbank for reporting this issue; unfixable by me for now to due lack of
 *    development access on a Mac
 *  - MSIE 9 ignores the cells' (inner) borders for some reason
 *  - if you have any others, let me know
 */
/**
 * Methods:
 *  .thfloat([options])
 *  .thfloat('init', [options]) - initialize THFloat on a new jQuery object
 *    options : see "Options" below
 *
 *  .thfloat('resize', [side]) - force the floating block to resize itself
 *      and each cell contained within to match the parent table; useful utility
 *      if you modify the original table contents and want to sync it with the floater
 *    side : "head" or "foot"; defaults to both
 *
 *  .thfloat('refresh', [side]) - force the floating block to refresh itself, as if
 *      the container has scrolled; useful for tables in blocks that toggle visibility
 *    side : "head" or "foot"; defaults to both
 *
 *  .thfloat('destroy') - remove THFloat instance from jQuery object
 */
/**
 * Options:
 *  side - the block of the table that is to be floated
 *    default: "head"
 *    "head" for <thead>
 *    "foot" for <tfoot>
 *
 *  attachment - the scrolling container to which the floated block is attached
 *    default: window
 *    string selector, DOM object, or jQuery object; 
 *
 *  noprint - do not display the floating block when the page is printed
 *    default: true
 *    boolean
 *
 *  sticky - force the floating block visible even when source block is in view
 *            (but not if the table is out of view entirely, of course)
 *    default: false
 *    boolean
 *
 *  onShow - see "Overridable Events" below
 *
 *  onHide - see "Overridable Events" below
 */
/**
 * Overridable Events:
 *  onShow(table, block) - triggered just after a floating block is created
 *    table : the floating <table> holding the block and its content
 *    block : the temporary <thead> or <tfoot> containing the content being floated
 *
 *  onHide(table, block) - triggered as the floating block is about to be destroyed
 *    table : the floating <table> holding the block and its content
 *    block : the temporary <thead> or <tfoot> containing the content being floated
 */
/**
 * CSS Styles:
 *  .thfloat-table
 *    class is added to the cloned, floating <table> holding the cloned <thead>/<tfoot>
 *
 *  .thfloat
 *    class is added to each <thead>/<tfoot> while it is floated
 *
 *  #thfloat[head|foot]-[table_id] (default; used if source table has an id)
 *  #thfloathead - if side "head" and table has no id
 *  #thfloatfoot - if side "foot" and table has no id
 *    id is assigned to the floating table holding the fixed <thead> or <tfoot>
$*/
/**
 * Example:
 *  html
 *  ----
 *    <!-- import jQuery from google: http://code.google.com/apis/libraries/devguide.html#jquery -->
 *    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
 *    <script type="text/javascript" src="./jquery.thfloat.js"></script>
 *
 *    <div id="scroller" style="height: 100px; overflow: auto;">
 *      <table id="floater">
 *        <thead>...a row of header cells...</thead>
 *        <tbody>...a bunch of content rows...</tbody>
 *        <tfoot>...a row of footer cells...</tfoot>
 *      </table>
 *    </div>
 *
 *  css
 *  ---
 *  #thfloathead-floater { border-bottom: 2px solid black; }
 *  #thfloatfoot-floater { border-top: 2px solid black; }
 *
 *  javascript
 *  ----------
 *    // make both the <thead> and <tfoot> float
 *    $("#floater")
 *      .thfloat({
 *        side : "head",
 *        attachment : "#scroller"
 *      })
 *      .thfloat({
 *        side : "foot",
 *        attachment : "#scroller"
 *      });
 *
 *    // ... do some stuff ...
 *
 *    // destroy just the <tfoot> floater
 *    $("#floater").thfloat('destroy', 'foot');
 */
(function($){
  (function($){
    // ROMMEL - bypass if it's already defined
    if (typeof($.fn.copyCSS) !== 'undefined')
      return;

    /*
    -- $.fn.getStyles and $.fn.copyCSS --
    Copyright 2013 Mike Dunn
    http://upshots.org/
    Permission is hereby granted, free of charge, to any person obtaining
    a copy of this software and associated documentation files (the
    "Software"), to deal in the Software without restriction, including
    without limitation the rights to use, copy, modify, merge, publish,
    distribute, sublicense, and/or sell copies of the Software, and to
    permit persons to whom the Software is furnished to do so, subject to
    the following conditions:

    The above copyright notice and this permission notice shall be
    included in all copies or substantial portions of the Software.

    THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
    EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
    MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
    NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
    LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
    OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
    WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
    */
    $.fn.getStyles = function(only, except){
      // the map to return with requested styles and values as KVP
      var product = {};
      // the style object from the DOM element we need to iterate through
      var style;
      // recycle the name of the style attribute
      var name;

      // if it's a limited list, no need to run through the entire style object
      if (only && only instanceof Array){
        for(var i = 0, l = only.length; i < l; i++){
          // since we have the name already, just return via built-in .css method
          name = only[i];
          product[name] = this.css(name);
        }
      } else {
        // otherwise, we need to get everything
        var dom = this.get(0);

        // standards
        if (window.getComputedStyle) {
          // convenience methods to turn css case ('background-image') to camel ('backgroundImage')
          var pattern = /\-([a-z])/g;
          var uc = function (a, b) {
              return b.toUpperCase();
          };      
          var camelize = function(string){
            return string.replace(pattern, uc);
          };

          // make sure we're getting a good reference
          if (style = window.getComputedStyle(dom, null)) {
            var camel, value;
            // opera doesn't give back style.length - use truthy since a 0 length may as well be skipped anyways
            if (style.length) {
              for (var i = 0, l = style.length; i < l; i++) {
                name = style[i];
                camel = camelize(name);
                value = style.getPropertyValue(name);
                product[camel] = value;
              }
            } else {
              // opera
              for (name in style) {
                camel = camelize(name);
                value = style.getPropertyValue(name) || style[name];
                product[camel] = value;
              }
            }
          }
        }
        // IE - first try currentStyle, then normal style object - don't bother with runtimeStyle
        else if (style = dom.currentStyle) {
          for (name in style) {
            product[name] = style[name];
          }
        }
        else if (style = dom.style) {
          for (name in style) {
            if (typeof style[name] != 'function') {
              product[name] = style[name];
            }
          }
        }
      }

      // remove any styles specified...
      // be careful on blacklist - sometimes vendor-specific values aren't obvious but will be visible...  e.g., excepting 'color' will still let '-webkit-text-fill-color' through, which will in fact color the text
      if(except && except instanceof Array){
        for(var i = 0, l = except.length; i < l; i++){
          name = except[i];
          delete product[name];
        }
      }

      // one way out so we can process blacklist in one spot
      return product;
    };

    // sugar - source is the selector, dom element or jQuery instance to copy from - only and except are optional
    $.fn.copyCSS = function(source, only, except){
      var styles = $(source).getStyles(only, except);
      return this.css(styles);
    };
  })(jQuery);

  /**
   * jQuery.browser for 1.9+
   * We all love feature detection but that's sometimes not enough.
   * @author Tero Piirainen
   */
  if (!$.browser) {
    var b = $.browser = {},
        ua = navigator.userAgent.toLowerCase(),
        match = /(chrome)[ \/]([\w.]+)/.exec(ua) ||
        /(webkit)[ \/]([\w.]+)/.exec(ua) ||
        /(opera)(?:.*version|)[ \/]([\w.]+)/.exec(ua) ||
        /(msie) ([\w.]+)/.exec(ua) ||
        ua.indexOf("compatible") < 0 && /(mozilla)(?:.*? rv:([\w.]+)|)/.exec(ua) || [];

    if (match[1]) {
      b[match[1]] = true;
      b.version = match[2] || "0";
    }
  }

  var methods = {
    init : function(options) {
      var settings = {
        side : 'head',        // "head" for <thead> or "foot" for <tfoot>
        attachment : window,  // selector, dom object, or jquery object - scrolling parent to attach to
        sticky : false,       // stay floating always, not just when the source block is out of view
        noprint : true,       // do not display when the page is printed
        onShow : function(table, block) {}, // called after the floating block (<thead> or <tfoot>) is created
        onHide : function(table, block) {}  // called as the block is about to be hidden (actually deleted)
      };

      if (typeof options === 'object')
        $.extend(settings, options);

      var $this = this,
          side = settings.side == 'foot' ? 'foot' : 'head',
          other = side == 'foot' ? 'head' : 'foot',
          ns = 'thfloat'+side,
          data = $this.data(ns)
      ;

      while (!data) {
        var $src = $("t"+side, this),
            $opp = $("t"+other, this)
        ;

        if (!$src.length)
          break;

        var id = ns+'-'+($this.attr('id')?$this.attr('id'):Math.floor(Math.random()*1000000));

        data = {
          settings : settings,
          active : false,
          clonetbl : $(this).clone(true).attr({id:id}).addClass('thfloat-table').css({zIndex:'1000',display:'none',position:'absolute'}).appendTo('body'),
          srcblock : $src,
          oppblock : $opp.length ? $opp : null,
          thwidths : [],
          cloneblk : null
        };

        if (settings.noprint)
          $('head').append('<style>@media print{#'+id+'{display:none!important}}</style>');

        data.clonetbl.children().remove();

        $this.data(ns, data);

        $(window)
          .bind('resize.'+ns, function(){
            $.each(['thfloathead','thfloatfoot'], function(i, ns){
              var data = $this.data(ns);
              if (!data)
                return;

              var thw = [];
              $("> tr", data.srcblock).children().each(function(){
                thw.push($(this).width());
              });

              data.thwidths = thw;
              $this.data(ns, data);
              $this.thfloat('_scroll', ns, $(data.settings.attachment));
            });
          })
          .resize()
        ;

        var a = $(settings.attachment).bind('scroll.'+ns, function(){
          $this.thfloat('_scroll', ns, this);
        });

        $this.thfloat('_scroll', ns, a);
        break;
      }

      return $this;
    },

    refresh : function(side) {
      var $this = $(this);

      $.each(['head', 'foot'], function(i, s){
        if (side && side != s)
          return;

        var ns = 'thfloat'+s,
            data = $this.data(ns);

        if (data)
          $this.thfloat('_scroll', ns, data.settings.attachment);
      });
    },

    resize : function(side) {
      var $this = $(this);

      $.each(['head', 'foot'], function(i, s){
        if (side && side != s)
          return;

        var ns = 'thfloat'+s,
            data = $this.data(ns);

        if (!data || !data.active)
          return;

        var thw = [];
        $("> tr", data.srcblock).children().each(function(){
          thw.push($(this).width());
        });

        var $el = $(data.settings.attachment),
            heightOffset = $.browser.mozilla || $.browser.opera || $.browser.msie ? -(($this.attr('cellspacing')||0)*2) : 0,
            edgeheight = s == 'foot' ? ((!$el.offset() ? $el.height() : $el.innerHeight()) - data.srcblock.outerHeight() + heightOffset) : 0, 
            edge = !$el.offset() ? ($el.scrollTop() + edgeheight) : ($el.offset().top + edgeheight);

        data.clonetbl.css({top:edge+'px',left:$this.offset().left+"px",width:$this.width()+'px'});
        $("> tr", data.cloneblk).children().each(function(i){
          $(this).css({width:thw[i]+'px',maxWidth:thw[i]+'px'});
        });

        data.thwidths = thw;
        $this.data(ns, data);
      });
    },

    destroy : function(side) {
      var $this = this;

      $.each(['thfloathead','thfloatfoot'], function(i, ns){
        var data = $this.data(ns);

        if (!data || (side && ('thfloat'+side) != ns))
          return;

        $(data.settings.attachment).unbind('.'+ns);
        $(window).unbind('.'+ns);

        data.clonetbl.remove();
        data.cloneblk && data.cloneblk.remove();
        $this.removeData(ns);
      });
      
      return $this;
    },

    _scroll : function(ns, element) {
      var $this = this,
          $el = $(element);

      var data = $this.data(ns);
      if (!data)
        return;

      var heightOffset = $.browser.mozilla || $.browser.opera || $.browser.msie ? -(($this.attr('cellspacing')||0)*2) : 0,
          edgeheight = data.settings.side == 'foot' ? ((!$el.offset() ? $el.height() : $el.innerHeight()) - data.srcblock.outerHeight() + heightOffset) : 0,
          edge = !$el.offset() ? ($el.scrollTop() + edgeheight) : ($el.offset().top + edgeheight),
          beyond = data.settings.side == 'foot' ?
            ((!data.settings.sticky && data.srcblock.offset().top < edge) || (!data.oppblock ? false : (data.oppblock.offset().top + data.oppblock.outerHeight() >= edge))) :
            ((!data.settings.sticky && data.srcblock.offset().top > edge) || (!data.oppblock ? false : (data.oppblock.offset().top <= edge + data.srcblock.outerHeight())))
      ;

      if (!data.active) {
        if (!beyond) {
          data.active = true;
          data.clonetbl.css({display:($this.is(':visible')?'table':'none'),top:edge+'px',left:$this.offset().left+"px",marginTop:'0',marginBottom:'0',width:$this.width()+'px'});
          data.cloneblk = data.srcblock.clone(true);
          data.cloneblk.addClass('thfloat');

          // we need to not only clone the block and rows and cells, but
          // the CSS of each of those
          data.cloneblk.copyCSS(data.srcblock);
          data.cloneblk.children().remove();
          // copy each row and its styles
          $("> tr", data.srcblock).each(function(){
            // for each row, copy each cell and its styles
            var tr = $(this).clone(true).copyCSS(this);
            tr.children().remove();

            $("> td,> th", this).each(function(){
              tr.append($(this).clone(true).copyCSS(this));
            });

            // finally add the new cloned row and cloned columns to our thead/tfoot block
            data.cloneblk.append(tr);
          });
          data.cloneblk.appendTo(data.clonetbl);

          $this.thfloat('resize',data.settings.side);

          data.settings.onShow && data.settings.onShow.apply(this, [data.clonetbl, data.cloneblk]);
        }
      }
      else {
        if (data.clonetbl.is(':visible') != $this.is(':visible'))
          data.clonetbl.css({display:($this.is(':visible')?'table':'none')});

        if (beyond) {
          data.settings.onHide && data.settings.onHide.apply(this, [data.clonetbl, data.cloneblk]);

          data.active = false;
          data.cloneblk.remove();
          data.cloneblk = null;
          data.clonetbl.css({display:'none'});
        }
        else
          $this.thfloat('resize',data.settings.side);
      }

      $this.data(ns, data);
    }
  };

  $.fn.thfloat = function(method) {
    if (methods[method])
      return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
    else if (typeof method === 'object' || !method)
      return methods.init.apply(this, arguments);
    else
      $.error('Method ' +  method + ' does not exist on jQuery.thfloat');
  };
})(jQuery);
