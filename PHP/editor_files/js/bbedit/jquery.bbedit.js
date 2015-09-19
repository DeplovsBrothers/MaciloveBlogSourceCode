/*
 * jQuery bbcode editor plugin
 *
 * Copyright (C) 2010 Joe Dotoff
 * http://www.w3theme.com/jquery-bbedit/
 *
 * Version 1.1
 *
 * Dual licensed under the MIT and GPL licenses:
 *   http://www.opensource.org/licenses/mit-license.php
 *   http://www.gnu.org/licenses/gpl.html
 */

(function($) {

  $.bbedit = {
    baseURL: null,
    i18n: {'default': {
      'b' : 'Жирный',
      'i' : 'Кавычки',
      'u' : 'Цитата',
      'em' : 'Em dash',
      'q' : 'Перечеркнутый',
      'h2': 'H2',
      'youtube': 'YouTube',
      'url' : 'Вставить ссылку',
      'url_ext' : 'Внешяя ссылка',
      'img' : 'Вставить картинку',
      'code' : 'Подстветить код',
      'quote' : 'Спрятать под кат',
      'biggrin' : 'Big grin',
      'cry' : 'Cry',
      'dizzy' : 'Dizzy',
      'funk' : 'Funk',
      'huffy' : 'Huffy',
      'lol' : 'Laugh out Loud',
      'loveliness' : 'Loveliness',
      'mad' : 'Mad',
      'sad' : 'Sad',
      'shocked' : 'Shocked',
      'shy' : 'Shy',
      'sleepy' : 'Sleepy',
      'smile' : 'Smile',
      'sweat' : 'Sweat',
      'titter' : 'Titter',
      'tongue' : 'Tongue out'
    }}
  };

  $.fn.extend({
    bbedit: function(settings) {
      this.defaults = {
        highlight: false,
        enableToolbar: true,
        enableSmileybar: true,
        lang: 'default',
        tags: 'b,i,u,s,url,url-ext,code,quote',
        smilies: 'biggrin,cry,dizzy,funk,huffy,lol,loveliness,mad,sad,shocked,shy,sleepy,smile,sweat,titter,tongue'
      }
      var settings = $.extend(this.defaults, settings);
      var tags = settings.tags.split(/,\s*/);
      if ($.bbedit.baseURL == null) {
        var scripts = $("script");
        for (var i = 0; i < scripts.length; i++) {
          if (scripts.eq(i).attr("src").indexOf('jquery.bbedit') > -1) {
            $.bbedit.baseURL = scripts.eq(i).attr("src").replace(/[^\/\\]+$/, '');
            break;
          }
        }
      }
      if (typeof $.bbedit.i18n[settings.lang] == 'undefined') {
        $.ajax({
          url: $.bbedit.baseURL + 'lang/' + settings.lang + '.js',
          async: false,
          dataType: "script",
          error: function() {
            settings.lang = 'default';
          }
        });
      }
      var toolHtml = '<div class="bbedit-toolbar">';
      for (var i in tags) {
        toolHtml += '<span class="bbedit-' + tags[i] + '" title="' + $.bbedit.i18n[settings.lang][tags[i]] + '">&nbsp;</span> ';
      }
      toolHtml += '</div>';


      return this.each(function() {
        var data = settings;
        data.range = null;
        data.ta = this;
        $(this).bind("select click keyup", function() {
          if (document.selection) {
            data.range = document.selection.createRange();
          }
        });
        if (settings.enableToolbar) {
          var toolbar = $(toolHtml);
          $(this).before(toolbar);
          if ($.browser.msie && parseInt($.browser.version) <= 6) {
            toolbar.children("span").mouseover(function() {
              $(this).addClass("hover");
            }).mouseout(function() {
              $(this).removeClass("hover");
            });
          }
          toolbar.find(".bbedit-b").click(function() {
            insertTag(data, '<strong>', '</strong>');
          });
          toolbar.find(".bbedit-i").click(function() {
            insertTag(data, '&laquo;', '&raquo;');
          });
          toolbar.find(".bbedit-em").click(function() {
            insertTag(data, '&mdash;');
          });
          toolbar.find(".bbedit-u").click(function() {
            insertTag(data, '[u]', '[/u]');
          });
          toolbar.find(".bbedit-h2").click(function() {
            insertTag(data, '[h2]', '[/h2]');
          });
          toolbar.find(".bbedit-s").click(function() {
            insertTag(data, '<p class="quotes">', '</p>');
          });
          toolbar.find(".bbedit-code").click(function() {
            insertTag(data, '[code]', '[/code]');
          });
          toolbar.find(".bbedit-quote").click(function() {
            insertTag(data, '[icut] <!-- Все что ниже будет спрятано под кат -->');
          });
          toolbar.find(".bbedit-url").click(function() {
            insertTag(data, function(text) {
              if (/^https?:\/\//i.test(text)) {
                return '[url]' + text + '[/url]';
              } else {
                var url = prompt('URL: ', '');
                if (url != null && url != '') {
                // if (!/^https?:\/\//i.test(url)) {
                 //   url = 'http://' + url;
                 // }
                  if (text == '') {
                    return '[url]' + url + '[/url]';
                  } else {
                    return '[url=' + url + ']' + text + '[/url]';
                  }
                }
                return false;
              }
            });
          });
          toolbar.find(".bbedit-youtube").click(function() {
            insertTag(data, function(text) {
                var url = prompt('YouTube URL: ', '');
                if (url != null && url != '') {
                
                return '[YT]' + url + '[/YT]';
                }
                return false;
             
            });

          });     
          toolbar.find(".bbedit-img").click(function() {
            insertTag(data, function(text) {
              if (/^https?:\/\//i.test(text)) {
                return '[img][src]' + text + '[/src][p][/p][/img]';
              } else {
                var url = prompt('Image: ', '');
                if (url != null && url != '') {
                  if (!/^https?:\/\//i.test(url)) {
  					//url =  'http://s3-eu-west-1.amazonaws.com/macilove-images/news/'+ url;
  					url =  'http://macilove.com/images/'+ url;
                  }
                  return '[img][src]' + url + '[/src][p][/p][/img]';
                }
                return false;
              }
            });
          });
          toolbar.find(".bbedit-url_ext").click(function() {
            insertTag(data, function(text) {
              if (/^https?:\/\//i.test(text)) {
                return '[url ext]' + text + '[/url]';
              } else {
                var url = prompt('URL: ', '');
                if (url != null && url != '') {
                  if (text != '') {
                    return '[url=' + url + ' ext]' + text + '[/url]';
                  }
                }
                return false;
              }
            });
          });
        }
        if (settings.enableSmileybar) {
          var smileybar = $(smileyHtml);
          $(this).after(smileybar);
          for (var i in smilies) {
            smileybar.find(".bbedit-" + smilies[i]).click(function() {
              insertTag(data, '[:Q' + $(this).attr("class").replace(/bbedit-/, '') + ']');
            });
          }
        }
      });
    }
  });

  function insertTag(data, tag, tag2) {
    var val, startPos, endPos;
    var ta = data.ta;
    var range = data.range;
    var text = '';
    if (range != null) {
      text = range.text;
    } else if (typeof ta.selectionStart != 'undefined') {
      startPos = ta.selectionStart;
      endPos = ta.selectionEnd;
      text = ta.value.substring(startPos, endPos);
    }
    if (typeof tag == 'function' || typeof tag == 'object') {
      val = tag(text);
      if (val === false) {
        if (range != null) {
          range.moveStart('character', text.length);
          range.select();
        } else if (typeof ta.selectionStart != 'undefined') {
          ta.selectionStart = startPos + text.length;
        }
        ta.focus();
        return;
      }
    } else {
      if (!tag2 || tag2 == '') {
        val = text + tag;
      } else {
        val = tag + text + tag2;
      }
    }
    if (range != null) {
      range.text = val;
      if (data.highlight) {
        range.moveStart('character', -val.length);
        //range.moveEnd('character', 0);
      } else {
        range.moveStart('character', 0);
        //range.moveEnd('character', 0);
      }
      range.select();
    } else if (typeof ta.selectionStart != 'undefined') {
      ta.value = ta.value.substring(0, startPos) + val + ta.value.substr(endPos);
      if (data.highlight) {
        ta.selectionStart = startPos;
        ta.selectionEnd = startPos + val.length;
      } else {
        ta.selectionStart = startPos + val.length;
        ta.selectionEnd = startPos + val.length;
      }
    } else {
      ta.value += val;
    }
    ta.focus();
  }

})(jQuery);