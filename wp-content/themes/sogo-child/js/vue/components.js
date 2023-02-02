

Vue.component('button-details', {
    props: ['offer_index'],
    data: function () {
        return {
            open: 'icon-plus-01-colorwhite'
        }
    },
    methods: {
        click: function () {
            if (this.open === 'icon-plus-01-colorwhite') {
                this.open = 'icon-minus-01-colorwhite'
            } else {
                this.open = 'icon-plus-01-colorwhite'
            }
        }
    },

    template: '<a data-toggle="collapse"  @click="click()"' +
    'class="compare-show-more-details-a" ' +
    ':href="\'#collapseOne-\'+offer_index"' +
    ' aria-expanded="true" aria-controls="collapseOne-1">' +
    '<span class="custom-circle bg-2"><i class="icon-x2 icon-x2 d-inline-block align-middle " :class="open"></i></span>' +
    ' <span class="text-custom-1 v-align-middle regular color-black">פרטים נוספים</span></a>'
});
Vue.component('contact-phone', {
    props: ['offer_index', 'selected' ,'subject'],

    mounted: function () {

    },
    computed: {
        show: function () {
            return app.mobileKey == this.offer_index;
        }
    },
    methods: {

        send: function (e) {
            var that = this;
            this.$validator.validateAll().then(function (result) {
              if(result){
                  jQuery.ajax({
                      type: "POST",
                      dataType: "json",
                      url: sogo.ajaxurl,
                      data: {
                          'action': 'sogo_send_ozar_offer',
                          'fullname': that.fullname,
                          'email': '',
                          'phone': that.phone,
                          'selected': that.selected,
                          'email_subject': that.subject,
                      },
                      success: function (response) {
                          that.thx = true;
                          setTimeout(function(){
                              that.thx = false;
                              app.mobileKey = -1;
                          }, 3000);
                      }
                  });
              }else{
                  jQuery("html, body").stop().animate({scrollTop:e.target.offsetHeight + 50}, 500, 'swing', function() { });
              }

            });
        }
    },
    data: function () {
        return {
            fullname: '',
            phone: '',
            thx: false,

        }
    },
    template: ' ' +
    '<div v-if="show"  class="contact-us-by-phone animated fadeInRight ">\n' +
    '\n' +
    '    <form action="" method="post"   @submit.prevent="send($event)" v-if="!thx" >\n' +
    '        <input class="ins_order" name="ins_order" type="hidden" value="">\n' +
    '        <input class="ins_link" name="ins_link" type="hidden" value="stage.hova.co.il/">\n' +
    '\n' +
    '        <div class="row bg-3 py-2">\n' +
    '\n' +
    '            <div class="col-lg-2 d-flex d-lg-block justify-content-center">\n' +
    '\n' +
    '                <span class="text-6 color-white">דברו איתנו</span>\n' +
    '\n' +
    '            </div>\n' +
    '\n' +
    '            <div class="col-lg-7 mb-3 mb-lg-0">\n' +
    '\n' +
    '                <!-- ROW -->\n' +
    '                <div class="row">\n' +
    '\n' +
    '                    <div class="col-lg-6">\n' +
    '\n' +
    '                        <div class="s-input-wrapper d-inline-block w-100">\n' +
    '\n' +
    '                            <label for="contact-compare-name-2-1" class="hidden-lg-up text-6 color-white medium">\n' +
    '\t\t\t\t\t\t\t\tשם מלא                            </label>\n' +
    '                            <input type="text" id="contact-compare-name-2-1" v-model="fullname" class="w-100" name="fullname"  v-validate="\'required\'" placeholder="שם מלא">\n' +
    '\n' + '                                           <span v-if="errors.first(\'fullname\')" class="invalid-feedback d-block mt-2">{{ errors.first("fullname") }}</span> ' +
    '                        </div>\n' +
    '\n' +
    '                    </div>\n' +
    '\n' +
    '                    <div class="col-lg-6">\n' +
    '\n' +
    '                        <div class="s-input-wrapper d-inline-block w-100">\n' +
    '\n' +
    '                            <label for="contact-compare-phone-1" class="hidden-lg-up text-6 color-white medium">\n' +
    '\t\t\t\t\t\t\t\tטלפון                            </label>\n' +
    '                            <input type="tel" id="contact-compare-phone-1" v-model="phone" name="phone" v-validate="\'required|digits:10\'" class="w-100 " placeholder="טלפון">\n' +
    '\n' + ' <span v-if="errors.first(\'phone\')" class="invalid-feedback d-block mt-2">{{ errors.first("phone") }}</span> ' +
    '                        </div>\n' +
    '\n' +
    '                    </div>\n' +
    '\n' +
    '                </div>\n' +
    '\n' +
    '            </div>\n' +
    '\n' +
    '            <div class="col-lg-3 text-left">\n' +
    '\n' +
    '                <button type="submit" class="  s-button s-button-2 bg-5 border-color-5 w-100">\n' +
    '\t\t\t\t\tהמשך                </button>\n' +
    '\n' +
    '            </div>\n' +
    '\n' +
    '        </div>\n' +
    '\n' +
    '    </form>\n' +
    '\n' +
        '<div class="row thx " v-if="thx"><div class="col bg-5 message py-2 color-white text-6 text-center">נשלח בהצלחה</div></div>'+
    '</div>'
});
Vue.component('contact-email', {
    props: ['offer_index', 'selected','subject'],

    mounted: function () {

    },
    computed: {
        show: function () {
            return app.emailKey == this.offer_index;
        }
    },
    methods: {

        send: function (e) {
            var that = this;
            this.$validator.validateAll('form3').then(function (result) {
                console.log(result);
                if(result){
                    jQuery.ajax({
                        type: "POST",
                        dataType: "json",
                        url: sogo.ajaxurl,
                        data: {
                            'action': 'sogo_send_ozar_offer',
                            'fullname': that.fullname,
                            'email': that.email,
                            'selected': that.selected,
                            'email_subject': that.subject,
                        },
                        success: function (response) {
                            that.thx = true;
                            setTimeout(function(){
                                app.emailKey = -1;
                                that.thx = false;

                            }, 3000);
                        }
                    });
                }else{
                    jQuery("html, body").stop().animate({scrollTop:e.target.offsetHeight + 50}, 500, 'swing', function() { });
                }

            });
        }
    },
    data: function () {
        return {
            fullname: '',
            email: '',
            thx: false,

        }
    },
    template: ' ' +
    '<div v-if="show"  class=" animated fadeInRight ">\n' +
    '\n' +
    '    <form action="" method="post"   @submit.prevent="send($event)" v-if="!thx"   data-vv-scope="form3">\n' +
    '        <input class="ins_order" name="ins_order" type="hidden" value="">\n' +
    '        <input class="ins_link" name="ins_link" type="hidden" value="stage.hova.co.il/">\n' +
    '\n' +
    '        <div class="row bg-5 py-2">\n' +
    '\n' +
    '            <div class="col-lg-2 d-flex d-lg-block justify-content-center">\n' +
    '\n' +
    '                <span class="text-6 color-white">דברו איתנו</span>\n' +
    '\n' +
    '            </div>\n' +
    '\n' +
    '            <div class="col-lg-7 mb-3 mb-lg-0">\n' +
    '\n' +
    '                <!-- ROW -->\n' +
    '                <div class="row">\n' +
    '\n' +
    '                    <div class="col-lg-6">\n' +
    '\n' +
    '                        <div class="s-input-wrapper d-inline-block w-100">\n' +
    '\n' +
    '                            <label for="contact-compare-name-2-1" class="hidden-lg-up text-6 color-white medium">\n' +
    '\t\t\t\t\t\t\t\tשם מלא                            </label>\n' +
    '                            <input type="text" id="contact-compare-name-2-1" v-model="fullname" class="w-100" name="fullname"  v-validate="\'required\'" placeholder="שם מלא">\n' +
    '\n' + '                                           <span v-if="errors.first(\'form3.fullname\')" class="invalid-feedback d-block mt-2">{{ errors.first("form3.fullname") }}</span> ' +
    '                        </div>\n' +
    '\n' +
    '                    </div>\n' +
    '\n' +
    '                    <div class="col-lg-6">\n' +
    '\n' +
    '                        <div class="s-input-wrapper d-inline-block w-100">\n' +
    '\n' +
    '                            <label for="contact-compare-phone-1" class="hidden-lg-up text-6 color-white medium">\n' +
    '\t\t\t\t\t\t\t\tמייל                            </label>\n' +
    '                            <input type="email" id="contact-compare-phone-1" v-model="email" name="email" v-validate="\'required|email\'" class="w-100 " placeholder="מייל">\n' +
    '\n' + ' <span v-if="errors.first(\'form3.email\')" class="invalid-feedback d-block mt-2">{{ errors.first("form3.email") }}</span> ' +
    '                        </div>\n' +
    '\n' +
    '                    </div>\n' +
    '\n' +
    '                </div>\n' +
    '\n' +
    '            </div>\n' +
    '\n' +
    '            <div class="col-lg-3 text-left">\n' +
    '\n' +
    '                <button type="submit" class="  s-button s-button-2 bg-3 border-color-3 w-100">\n' +
    '\t\t\t\t\tהמשך                </button>\n' +
    '\n' +
    '            </div>\n' +
    '\n' +
    '        </div>\n' +
    '\n' +
    '    </form>\n' +
    '\n' +
    '<div class="row thx " v-if="thx"><div class="col bg-5 message py-2 color-white text-6 text-center">נשלח בהצלחה</div></div>'+
    '</div>'
});
