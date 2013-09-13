/**
 * JSLite compressed.
 * 
 * @author Avaq <aldwin.vlasblom@gmail.com>, https://github.com/Avaq
 * @version 0.4.0-beta
 * 
 * This version contains:
 * - JSlite.js
 * - ClassFactory.js
 */
(function(e,t){function n(e){this.message=e||this.message}n.prototype={name:"JSLiteException",message:"An error occurred in JSLite.",toString:function(){return this.message}};e.JSLite={};e.JSLite.JSLiteException=n})(this||window);(function(e){"use strict";function r(e){var r,i,s=n.call(arguments,1);for(r in s){if(t.call(s,r)){for(i in s[r]){if(t.call(s[r],i)){e[i]=s[r][i]}}}}return e}function i(e,n){var r=n._STATIC;while(r&&!t.call(r,e)){r=r._PARENT}return r}function s(e){this._class=this._noop=e}function o(){var e=function(){};this._STATIC=e;e._PARENT=o;e.prototype=this;return new s(e)}var t=Object.prototype.hasOwnProperty,n=Array.prototype.slice;s.prototype={extend:function(e){this._class.prototype=r(Object.create(e.prototype),this._class.prototype);this._class._PARENT=e;if(!this.hasConstructor()){this.construct(function(){e.apply(this,arguments)})}return this},construct:function(e){e.prototype=this._class.prototype;r(e,this._class);this._class=e.prototype._STATIC=e;return this},members:function(e){r(this._class.prototype,e);return this},statics:function(e){r(this._class,e);return this},finalize:function(){return this._class},hasConstructor:function(){return this._class!==this._noop}};o._PARENT=false;o.prototype={proxy:function(e){var t=this,r=n.call(arguments,1);return function(){return e.apply(t,r.concat(n.call(arguments)))}},"super":function(e,t){return this._STATIC._PARENT.prototype[e].apply(this,t||[])},getStatic:function(e){var t=i(e,this);return t?t[e]:undefined},callStatic:function(e,t){var n=i(e,this);if(!n)throw new JSLite.JSLiteException("None of the parent classes of '"+typeof this+"' have method '"+e+"'.");return n[e].apply(n,t||[])}};e.JSLite.ClassFactory=s;e.JSLite.Class=o})(this||window)
