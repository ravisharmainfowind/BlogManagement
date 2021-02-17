var RequiredMsg = "The FIELDNAME field is required.",
    EmailMsg = "The FIELDNAME field must contain a valid email address.",
    NumericMsg = "The FIELDNAME must contain only numeric value.",
    FloatMsg = "The FIELDNAME must contain numeric value.",
    MinValueMsg = "The FIELDNAME should be exceed LENGTH characters in length.",
    MaxValueMsg = "The FIELDNAME can not exceed LENGTH characters in length.",
    ValidFileMsg = "The FIELDNAME only FILETYPE formats are allowed.",
    BetweenMsg = "The FIELDNAME should be between TO to FROM.",
    AlphaNumericMsg = "The FIELDNAME must contain numeric and alphabets.",
    ValidUrlMsg = "The FIELDNAME must contain valid url.";

(function() {
  
    var privateVar = {};
    var EmailExpr = /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))){2,6}$/i;
    var Range = new RegExp(/range-[0-9]+-[0-9]+$/);
    var MinExpr = new RegExp(/minlength-[0-9]+/);
    var MaxExpr = new RegExp(/maxlength-[0-9]+/);
    var FileExpr = new RegExp(/valid-filetype-[a-zA-Z,]+$/);
    var NumericExpr = /^[0-9]+$/;
    var FloatExpr = /^[0-9\.]+$/;
    //var BetweenExpr = /^between-[0-9]+-[0-9]+/;
    var BetweenExpr = new RegExp(/between-[0-9]+-[0-9]+/);
    var AlbhaNumericExpr = /^([0-9]|[a-z])+|([0-9a-z]+)$/i;
    var NameExpr = new RegExp(/usename-#[a-z A-Z0-9]+#$/);
    var ValidUrlExpr = new RegExp(/(http(s)?:\\)?([\w-]+\.)+[\w-]+[.com|.in|.org]+(\[\?%&=]*)?/);
    var tempmsg = '';

    this.Validate = function(option) {

        var global_defaults = {
                ErrorLevel: 0,
                FormName: "",
                validateHidden: true,
                RequiredMsg: RequiredMsg,
                EmailMsg: EmailMsg,
                NumericMsg: NumericMsg,
                FloatMsg: FloatMsg,
                MinValueMsg: MinValueMsg,
                MaxValueMsg: MaxValueMsg,
                ValidFileMsg: ValidFileMsg,
                BetweenMsg: BetweenMsg,
                AlphaNumericMsg: AlphaNumericMsg,
                ValidUrlMsg: ValidUrlMsg,
                callback: ""
            };
        

        var _this = this;
        var defaults = {};
        _this.defaults = __extent(global_defaults,option);

        _this.prepare();
        _this.addListener();
       
         
  
    }

      Validate.prototype.prepare = function() {
        var _ = this;
        if(document.forms[_.defaults.FormName] === undefined){
            return false;
        }
        elements = document.forms[_.defaults.FormName].elements; 


        privateVar[_.defaults.FormName] = {
            "field"    : [],
            "hasError" : {}
        };

        for(i=0; i<elements.length; i++)
        {   
            privateVar[_.defaults.FormName].field.push({
                "id" : elements[i],
                "rules" : elements[i].className
            });   
            if(elements[i].nextElementSibling != null) {
                if(hasClass(elements[i].nextElementSibling.className,'error-msg')){
                    continue;
                }
            }

            /*var div = document.createElement("div"); 
                div.className = 'error-msg';
            elements[i].parentNode.appendChild(div);*/
            var div = document.createElement("div"); 
                div.className = 'error-msg';
            elements[i].parentNode.insertBefore(div,elements[i].nextSibling);
            

        }
    }

    Validate.prototype.addListener = function() 
    {
        var _ = this;
        if(document.forms[_.defaults.FormName] === undefined){
            return false;
        }
        document.forms[_.defaults.FormName].addEventListener("submit", function(evt)
        {
            if(_.get_validate() == false) {
                evt.preventDefault();
            } else if(isObject(_.defaults.callback) == true) {
                _.defaults.callback();
                evt.preventDefault();
            }
        });
    }

    Validate.prototype.get_validate = function() {
        var obj = this;
        var flag = true;
        var formdata = privateVar[obj.defaults.FormName];
        formdata.hasError = {};

        reset(obj);
        for(var i in formdata.field)
        { 
            if(hasClass(formdata.field[i].rules,'left-disabled') & formdata.field[i].id.disabled == true) {
                continue;
            }
      
            if(required(formdata.field[i],obj) == false) {
                flag = false;
            }
            if(numeric(formdata.field[i],obj) == false){
                flag = false;
            }
            if(valid_email(formdata.field[i],obj) == false){
                flag = false;
            }
            if(min_value(formdata.field[i],obj) == false){
                flag = false;
            }
            if(max_value(formdata.field[i],obj) == false){
                flag = false;
            }
            if(valid_file(formdata.field[i],obj) == false){
                flag = false;
            }
            if(between(formdata.field[i],obj) == false){
                flag = false;
            }
            if(albha_numeric(formdata.field[i],obj) == false){
                flag = false;
            }
            if(float_value(formdata.field[i],obj) == false){
                flag = false;
            }
             if(valid_url(formdata.field[i],obj) == false){
                flag = false;
            }


        }
        privateVar[obj.defaults.FormName] = formdata;
        return flag;
    }

    this.autoload = function() {
        /*var form = document.forms;

        
        for(var i = 0; i < form.length; i++) {
            //console.log(form[i])
            //console.log(form[i].age);
            
        }*/
    }, 
    this.isObject = function(val) {
        return val instanceof Object; 
    }
    this.hasClass = function(allclassName,classname){
        return (' ' + allclassName + ' ').indexOf(' ' + classname + ' ') > -1;
    },
    this.reset = function(_this) {
        try
        {

        var ErrBorder = document.forms[_this.defaults.FormName].getElementsByClassName("has-error");

        var ErrContainer = document.forms[_this.defaults.FormName].getElementsByClassName("error-msg");

        for (var j = ErrBorder.length - 1; j >= 0; --j) {
            if(ErrBorder[j].className != undefined) {
                ErrBorder[j].className = ErrBorder[j].className.replace('has-error','');
            }
        }
        for(var i in ErrContainer) {
            ErrContainer[i].innerHTML = '';
        }
        }catch(e) {
            console.log(e);
        }
    },
    this.addError = function(element,obj,msg) {

        try
        {
            if(!privateVar[obj.FormName].hasError.hasOwnProperty(element.name)) 
            {
                if(isVisible(element) == false && obj.validateHidden == false) {
                    return;
                }

                privateVar[obj.FormName].hasError[element.name] = true;
                if(NameExpr.test(element.className) == false) {
                    msg = msg.replace('FIELDNAME', element.name).replace(/_/g,' ');
                } else {
                    temp = element.className.match(NameExpr)[0].replace('usename-#','').replace('#','');
                    msg = msg.replace('FIELDNAME', temp);
                }

                (element.nextElementSibling).innerHTML = msg;


                for(var i=0;i<obj.ErrorLevel; i++) {
                    if(!hasClass(element.className,'rs-me-head')) {
                        if(element.parentNode != null) {
                            element = element.parentNode;
                        }
                    } else {
                        break;
                    }
                }
                if(!hasClass(element.className,'has-error')) {            
                    element.className = element.className + " has-error";
                }
                return false;
            }
        } catch(e) {
            console.log(e);
        }
    },
    __extent = function(option, useroption){
        for(var i in useroption) {
            option[i] = useroption[i];
        }
        return option;
    }
    check = function (field) {
        if(hasClass(field.rules,'minlength'))
        {
            if(!privateVar[defaults.FormName].hasError.hasOwnProperty(privateVar[defaults.FormName].field[i].id.name))
            {
                if(NumericExpr.test(value) == false) {
                    addError(privateVar[defaults.FormName].field[i].id,defaults);
                }
            }
        }
    },
     
    required = function(field,_this) {

        var value = (field.id.value).trim();
        if(hasClass(field.rules,'required'))
        {
            if(!value.length > 0 ) {                
                return addError(field.id,_this.defaults,_this.defaults.RequiredMsg);
            }
        }
    },
    valid_email = function( field, _this ) {
        var value = (field.id.value).trim();
        if(hasClass(field.rules,'valid-email') & !hasClass(field.id.className,'has-error'))
        {
            if(EmailExpr.test(value) == false) {
                return addError(field.id,_this.defaults,_this.defaults.EmailMsg);
            }
        }
    },
    numeric = function( field, _this ) {
        if(hasClass(field.rules,'numeric') & !hasClass(field.id.className,'has-error')) {
            return check_numeric(field, _this);
        }
    },
    check_numeric = function(field, _this) {
        var value = (field.id.value).trim();
        if(NumericExpr.test(value) == false && value.length > 0) {
            return addError(field.id,_this.defaults,_this.defaults.NumericMsg);
        }
    },
    float_value = function( field, _this ) {
        if(hasClass(field.rules,'float') & !hasClass(field.id.className,'has-error')) {
            var value = (field.id.value).trim();
            if(FloatExpr.test(value) == false && value.length > 0) {
                return addError(field.id,_this.defaults,_this.defaults.FloatMsg);
            }
        }
    },
    min_value = function( field, _this ) 
    {
        if(field.rules.match(MinExpr) && !hasClass(field.id.className,'has-error'))
        {
            var value = (field.id.value).trim();
            if(value != '')
            {
                var rules = field.rules.match(MinExpr)[0];
                if(value.length < rules.split('-')[1]) {
                    tempmsg = _this.defaults.MinValueMsg.replace('LENGTH', rules.split('-')[1]);
                    return addError(field.id,_this.defaults,tempmsg);
                }
            }
        }
    },
    max_value = function( field, _this ) 
    {
        if(field.rules.match(MaxExpr) && !hasClass(field.id.className,'has-error'))
        {
            var value = (field.id.value).trim();
            if(value != '')
            {
                var rules = field.rules.match(MaxExpr)[0];
                if(value.length > rules.split('-')[1]) {
                    tempmsg = _this.defaults.MaxValueMsg.replace('LENGTH', rules.split('-')[1]);
                    return addError(field.id,_this.defaults,tempmsg);
                }
            }
        }
    },
    valid_file = function( field, _this ) 
    {
        if(field.rules.match(FileExpr) && !hasClass(field.id.className,'has-error') && field.id.type == 'file')
        {

            if((field.id.value).trim() != '')
            {
                var extention = ((field.id.value).trim()).split('.');
            
                extention = extention[extention.length -1];
                var rules = (field.rules.match(FileExpr)[0]).split('-')[2];

                if(rules.split(',').indexOf(extention.toLowerCase()) == -1) {
                    tempmsg = _this.defaults.ValidFileMsg.replace('FILETYPE', rules);
                    return addError(field.id,_this.defaults,tempmsg);
                }
            }
        }
    },
    between = function( field, _this ) 
    {     
        var values = (field.id.value).trim();
        if(values != '') {
            //if(BetweenExpr.test(field.rules))
            if(field.rules.match(BetweenExpr))
            {            
                console.log('sfsdf');
                var rules = (field.rules.match(BetweenExpr)[0]).replace('between-','').split('-');
                
                if(rules.length == 2) {
                    if(values.length < rules[0] || values.length > rules[1]) {
                        tempmsg = _this.defaults.BetweenMsg.replace('TO', rules[0]).replace('FROM', rules[1]);
                        return addError(field.id,_this.defaults,tempmsg);
                        
                    }
                }
            }
        }
    },
    albha_numeric = function( field, _this ) 
    {        
        if((field.id.value).trim() != '') 
        {
            if(hasClass(field.rules,'alpha-numeric'))
            {
                if(AlbhaNumericExpr.test(field.id.value) == false) {
                    return addError(field.id,_this.defaults,_this.defaults.AlphaNumericMsg);
                }
            }
        }
    },
    valid_url = function( field, _this ) 
    {        
        if((field.id.value).trim() != '') 
        {
            if(hasClass(field.rules,'valid_url') & !hasClass(field.id.className,'has-error'))
            {
                if(ValidUrlExpr.test(field.id.value) == false) {
                    return addError(field.id,_this.defaults,_this.defaults.ValidUrlMsg);
                }
            }
        }
    },
    isVisible = function(ele) {
      return  ele.clientWidth !== 0 &&
        ele.clientHeight !== 0 &&
        ele.style.opacity !== 0 &&
        ele.style.visibility !== 'hidden';
    }

}());


