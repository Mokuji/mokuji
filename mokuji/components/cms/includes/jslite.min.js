/**
 * JSLite compressed.
 * 
 * @author Avaq <aldwin.vlasblom@gmail.com>, https://github.com/Avaq
 * @version 0.3.0-beta
 * 
 * This version contains:
 * - JSlite.js
 * - ClassFactory.js
 */
(function(e,t){function n(e){this.message=e||this.message}n.prototype={name:"JSLiteException",message:"An error occurred in JSLite."};e.JSLite={};e.JSLite.JSLiteException=n})(this||window);(function(e){"use strict";function r(e){var r,i,s=n.call(arguments,1);for(r in s){if(t.call(s,r)){for(i in s[r]){if(t.call(s[r],i)){e[i]=s[r][i]}}}}return e}function i(e){this._class=this._noop=e}function s(){var e=function(){};this._STATIC=e;e.prototype=this;return new i(e)}var t=Object.prototype.hasOwnProperty,n=Array.prototype.slice;i.prototype={extend:function(e){this._class.prototype=r(Object.create(e.prototype),this._class.prototype);if(!this.hasConstructor()){this.construct(function(){e.apply(this,arguments)})}return this},construct:function(e){e.prototype=this._class.prototype;r(e,this._class);this._class=e.prototype._STATIC=e;return this},members:function(e){r(this._class.prototype,e);return this},statics:function(e){r(this._class,e);return this},finalize:function(){return this._class},hasConstructor:function(){return this._class!==this._noop}};s.prototype={proxy:function(e){var t=this,r=n.call(arguments,1);return function(){return e.apply(t,r.concat(n.call(arguments)))}}};e.JSLite.ClassFactory=i;e.JSLite.Class=s})(this||window)
