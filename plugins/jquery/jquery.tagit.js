/*
 * INFORMATION
 * ---------------------------
 * Owner:     jquery.webspirited.com
 * Developer: Matthew Hailwood
 * ---------------------------
 *
 * CHANGELOG:
 * ---------------------------
 * 1.1
 * Fixed bug 01
 * 1.2
 * Added select option
 * * hidden select so tags may be submitted via normal form.
 * 1.3
 * Fixed bug 02
 * 1.4
 * Fixed bug 03
 * Fixed bug 04
 *
 * ---------------------------
 * Bug Fix Credits:
 * --
 * * Number: 01
 * * Bug:  Clicking autocomplete option does not add it to the array
 * * Name: Ed <tastypopsicle.com>
 * --
 * * Number: 02
 * * Bug: Unable to give select a name
 * * Name: Ed <tastypopsicle.com>
 * --
 * * Number 03
 * * Bug: reference to incorrect variable (tagArray vs tagsArray)
 * * Name: claudio <unknown>
 * --
 * * Number 04
 * * Bug: console.log() left in code
 * * Name: claudio <unknown>
 */
(function($){
  $.widget("ui.tagit",{
		options:{
			placeholder:"placeholder",
			maxlength:40,
			tagSource:[],
			triggerKeys:["enter","space","comma","tab"],
			initialTags:[],
			minLength:1,
			select:true,
			allowNewTags:true,
			emptySearch:false
		},
		_keys:{
			backspace:[8],
			enter:[13],
			space:[32],
			comma:[191],
			tab:[9]
    },
		_create:function(){
			$.ui.autocomplete.prototype._renderItem=function(ul,item){
				var re=new RegExp("^"+this.term);
				var t=item.label.replace(re,'<span class="autocompleteBold">'+this.term+"</span>");
				if(item.extra){
					t='<span class="autocompleteExtra">'+item.extra+":</span> "+t
        }
        return $("<li></li>").data("item.autocomplete",item).append("<a>"+t+"</a>").appendTo(ul)
      };

			var self=this;
			this.tagsArray=[];
			this.timer=null;
			this.element.addClass("tagit");
			this.element.children("li").each(function(){
				self.options.initialTags.push($(this).text())
				});
			this.element.html('<li class="tagit-new"><input placeholder="'+this.options.placeholder+'" class="tagit-input" type="text" maxlength="'+this.options.maxlength+'" /></li>');
			this.input=this.element.find(".tagit-input");
			$(this.element).click(function(e){
				if($(e.target).hasClass("tagit-close")){
					$(e.target).parent().remove();
					var text=$(e.target).parent().text();
					self._popTag(text.substr(0,text.length-1))
					}else{
					self.input.focus();
					if(self.options.emptySearch&&$(e.target).hasClass("tagit-input")&&self.input.val()==""&&self.input.autocomplete!=undefined){
						self.input.autocomplete("search")
						}
					}
			});
	var os=this.options.select;
	this.options.appendTo=this.element;
	this.options.source=this.options.tagSource;
	this.options.highlight=true;
	this.options.select=function(event,ui){
		clearTimeout(self.timer);
		if(ui.item.extraeng){
			self._addTag(ui.item.value, ui.item.extraeng)
		} else {
			self._addTag(ui.item.value);
		}
		return false
		};

	this.input.autocomplete(this.options);
		this.options.select=os;
		this.input.keydown(function(e){
		var lastLi=self.element.children(".tagit-choice:last");
		if(e.which==self._keys.backspace){
			return self._backspace(lastLi)
			}
			if(self._isInitKey(e.which)){
			e.preventDefault();
			if(self.options.allowNewTags&&$(this).val().length>=self.options.minLength){
				self._addTag($(this).val())
				}else{
				if(!self.options.allowNewTags){
					self.input.val("")
					}
				}
		}
	if(lastLi.hasClass("selected")){
		lastLi.removeClass("selected")
		}
		self.lastKey=e.which
  });

  this.input.blur(function(e){
    var v=$(this).val();
    if(self.options.allowNewTags){
      self.timer=setTimeout(function(){
        self._addTag(v)
        },200)
      }
      $(this).val("");
    return false
    });
  String.prototype.trim=function(){
    return this.replace(/^\s+|\s+$/g,"")
    };

  if(this.options.select){
    this.element.after('<select class="tagit-hiddenSelect" name="'+$(this.element).parent().children(".tagitid").attr("id")+'" multiple="multiple"></select>');
    this.select=this.element.siblings(".tagit-hiddenSelect")
    }
    this._initialTags()
    },
  _popSelect:function(text){
    this.select.children('option[value="'+text+'"]').remove();
    this.select.change()
    },
  _addSelect:function(value,extraeng){
      this.select.append('<option selected="selected" value="'+value+'">'+value+"</option>");
    this.select.change()
    },
  _popTag:function(text){
    $.inArray(text,this.tagsArray);
    if(text==undefined){
      text=this.tagsArray.pop()
      }else{
      var index=($.inArray(text,this.tagsArray)==-1?this.tagsArray.length-1:$.inArray(text,this.tagsArray));
      this.tagsArray.splice(index,1)
      }
      if(this.options.select){
      this._popSelect(text)
      }
    },
  _addTag:function(value, extraeng){
    this.input.val("");
    value=value.replace(/,+$/,"");
    value=value.trim();
    if(value==""||this._exists(value)){
      return false
      }
      var tag="";
    tag='<li class="tagit-choice">'+value+'<a class="tagit-close">x</a></li>';
    $(tag).insertBefore(this.input.parent());
    this.input.val("");
    this.tagsArray.push(value);
    if(this.options.select){
      this._addSelect(value,extraeng)
      }
      return true
    },
  _exists:function(value){
    if(this.tagsArray.length==0||$.inArray(value,this.tagsArray)==-1){
      return false
      }
      return true
    },
  _isInitKey:function(keyCode){
    var keyName="";
    for(var key in this._keys){
      if($.inArray(keyCode,this._keys[key])!=-1){
        keyName=key
        }
      }
    if($.inArray(keyName,this.options.triggerKeys)!=-1){
    return true
    }
    return false
  },
  _removeTag:function(){
    this._popTag();
    this.element.children(".tagit-choice:last").remove()
    },
  _backspace:function(li){
    if(this.input.val()==""){
      if(this.lastKey==this._keys.backspace){
        this._popTag(li.html().replace('<a class="tagit-close">x</a>',""));
        li.remove();
        this.lastKey=null
        }else{
        li.addClass("selected");
        this.lastKey=this._keys.backspace
        }
      }
    return true
  },
  _initialTags:function(){
    var input=this;
    if(this.options.initialTags.length!=0){
      this.options.initialTags.each(function(i){
        input._addTag(i)
        })
      }
    },
  tags:function(){
    return this.tagsArray
    },
  destroy:function(){
    $.Widget.prototype.destroy.apply(this,arguments);
    this.tagsArray=[]
    }
  })
})(jQuery);