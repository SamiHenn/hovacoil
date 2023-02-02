<?php
/**
 * Template Name:Life Insurance
 */
sogo_vue_load();
get_header(); ?>
<style>
#samibg {
  background-image: url("https://www.hova.co.il/wp-content/uploads/2019/12/life-insurance-bg.jpg");
  background-position: top;
  background-repeat: no-repeat;
  background-size: 100%;
  background-color: #ebebeb;
}
</style>
<div id="samibg" class="page-insurance-compare-1 pb-5">
    <section class="section-insurance-compare-1">
        <!-- CONTAINER-FLUID -->
        <div class="container-fluid">
            <!-- ROW TITLE-->
            <div class="row justify-content-center mb-3">
                <div class="col-lg-4">
                    <h1 class="text-2 color-4 mt-3"><?php the_title(); ?></h1>
					<h2 class="text-4 color-3">מחשבון השוואת מחירים</h2>
                </div>
            </div>
            <div class="row justify-content-center mb-1">
								<div class="col-lg-4">
								<div style="float: right" class="col-8 text-right">
                                <!--<a class="color-3 text-5 text-center">משווים וחוסכים</a>-->
                            </div>
                            <div style="float: right" class="col-4 text-left">
                              <a class="color-3 text-5"  href="<?php the_permalink()?>">נקה</a>
                            </div>
                            </div>
                            </div>
            <!-- ROW -->
            <div class="row justify-content-center">
                <div class="col-lg-10 col-xl-4">
                    <div style="box-shadow: 0 8px 6px -6px #000" id="app">
                        <div class="row">
                            <div class="col-12">
                                <div id="insurance-accordion" role="tablist" aria-multiselectable="true">
                                    <!-- TAB 1 -->
                                    <div class="card " v-show="activeTab==1" :class="isActiveTab(1)" style="border-bottom: 0px solid; border-radius: 10px">
                                        <div class="card-header p-0" role="tab" id="headingOne">
                                            <h5 class="mb-0 text-5">
                                                <a data-toggle="" data-target="#collapseOne"
                                                   class="d-flex align-items-center p-card"
                                                   data-parent="#insurance-accordion" aria-expanded="true"
                                                   aria-controls="collapseOne">
                                                    פרטי הביטוח
                                                    <p class="d-flex flex-wrap mr-1">
                                                        <span class="d-start"></span>
                                                        <span class="d-middle-line d-none"> - </span>
                                                        <span class="d-end ml-1"></span>
                                                    </p>
                                                </a>
                                            </h5>
                                        </div>
                                        <div id="collapseOne" class="collapse" :class="isActiveTab(1)"
                                             role="tabpanel"
                                             aria-labelledby="headingOne">
                                            <div class="card-block mb-3">
                                                <!-- CONTAINER-FLUID -->
                                                <div class="container-fluid">
                                                    <!-- ROW -->
                                                    <div class="row mb-5">
                                                        <div class="col-lg-12 px-0 px-lg-2">
                                                            <b-container class="mt-3">
                                                                <b-form @submit.prevent="onStep1()"
                                                                        data-vv-scope="form1"
                                                                        v-if="show">
                                                                    <!-- suites type -->
                                                                    <div class="row">
                                                                        <div class="col-md-6 mb-3">
                                                                            <div class="s-radio-wrapper">
                                                                                <label class="text-5 color-6 d-inline-block mb-1">
                                                                                    מין המבוטח
                                                                                </label>
                                                                                <div class="d-flex">
                                                                                    <input type="radio"
                                                                                           class="form-radio-input opacity-0 p-absolute"
                                                                                           name="ListOfInsured[0].Gender"
                                                                                           v-model="ListOfInsured[0].Gender"
                                                                                           id="gender1" value="84400001"
                                                                                           data-val="Gender"
                                                                                           v-validate="'required'">
                                                                                    <label class="form-radio-label radio-btn-style p-relative text-5 flex-grow-1"
                                                                                           for="gender1">
                                                                                        זכר
                                                                                    </label>
                                                                                    &nbsp;
                                                                                    <input type="radio"
                                                                                           class="form-radio-input opacity-0 p-absolute"
                                                                                           name="ListOfInsured[0].Gender"
                                                                                           v-model="ListOfInsured[0].Gender"
                                                                                           id="gender2" value="84400002"
                                                                                           data-val="Gender"
                                                                                           v-validate="'required'">
                                                                                    <label class="form-radio-label radio-btn-style p-relative text-5 flex-grow-1"
                                                                                           for="gender2">
                                                                                        נקבה
                                                                                    </label>
                                                                                </div>
                                                                                <span class="invalid-feedback d-block mt-2">{{ errors.first('form1.ListOfInsured[0].Gender') }}</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="s-input-wrapper mb-3">
                                                                        <label class="text-5 color-6"><?php _e( 'Birthday', 'sogoc' ); ?></label>
                                                                        <div class="form-group date-picker mb-0  ">
                                                                            <input type="text" readonly="readonly"
                                                                                   data-start="<?php echo $start_birthday; ?>"
                                                                                   class="w-100 medium birthday-datepicker"
                                                                                   v-model="ListOfInsured[0].BirthDate"
                                                                                   name="ListOfInsured[0].BirthDate"
                                                                                   readonly
                                                                                   v-validate="'required'"
                                                                            />
                                                                        </div>
                                                                        <span class="invalid-feedback d-block mt-2">{{ errors.first('ListOfInsured[0].BirthDate') }}</span>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-md-6 mb-3">
                                                                            <div class="s-radio-wrapper">
                                                                                <label class="text-5 color-6 d-inline-block mb-1">
                                                                                    האם מעשן?</label>
                                                                                <div class="d-flex">
                                                                                    <input type="radio"
                                                                                           class="form-radio-input opacity-0 p-absolute"
                                                                                           name="ListOfInsured[0].IsSmoking"
                                                                                           v-model="ListOfInsured[0].IsSmoking"
                                                                                           id="smoking1" value="true"
                                                                                           data-val="IsSmoking" v-validate="'required'">
                                                                                    <label class="form-radio-label radio-btn-style p-relative text-5 flex-grow-1"
                                                                                           for="smoking1">
                                                                                        כן
                                                                                    </label>
                                                                                    &nbsp;
                                                                                    <input type="radio"
                                                                                           class="form-radio-input opacity-0 p-absolute"
                                                                                           name="ListOfInsured[0].IsSmoking"
                                                                                           v-model="ListOfInsured[0].IsSmoking"
                                                                                           id="smoking2" value="false"
                                                                                           data-val="IsSmoking" v-validate="'required'">
                                                                                    <label class="form-radio-label radio-btn-style p-relative text-5 flex-grow-1"
                                                                                           for="smoking2">
                                                                                        לא
                                                                                    </label>
                                                                                </div>
                                                                                <span class="invalid-feedback d-block mt-2">{{ errors.first('ListOfInsured[0].IsSmoking') }}</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <b-form-group
                                                                            :invalid-feedback="errors.first('form1.DesiredSum')"
                                                                            :state="!errors.has('DesiredSum')"
                                                                            label="סכום ביטוח מבוקש">
                                                                        <b-form-input type="number"
                                                                                      v-model="DesiredSum"
                                                                                      name="DesiredSum"
                                                                                      v-validate="'required|between:200000,5000000'"
                                                                        >
                                                                    </b-form-group>
                                                                    <div class="entry-content"
                                                                         v-html="params.description"></div>
                                                                    <div class="text-left">
                                                                        <b-button :disabled="loader"
                                                                                  class="btn-next s-button s-button-2 bg-5 border-color-5"
                                                                                  type="submit" variant="primary"
                                                                                  :disabled="!loader" id="step1">
                                                                            <span><?php _e( 'Continue', 'sogoc' ); ?></span>
                                                                            <i v-if="!loader"
                                                                               class="icon-arrowleft-01-colorwhite icon-x2 d-inline-block align-middle"></i>
                                                                            <span v-if="loader"
                                                                                  class="loader d-inline-block align-middle"
                                                                                  role="status"
                                                                                  aria-hidden="true"></span>
                                                                        </b-button>

                                                                    </div>
                                                                </b-form>
                                                            </b-container>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- TAB 2 results -->
                                    <div class="card" v-show="activeTab==2" :class="isActiveTab(2)">
                                        <div class="card-header p-0" role="tab" id="headingTwo">
                                            <h5 class="mb-0 text-5">
                                                <a data-toggle="" data-target="#collapseTwo"
                                                   class="d-flex align-items-center p-card"
                                                   data-parent="#insurance-accordion" aria-expanded="true"
                                                   aria-controls="collapseOne">
                                                    בחר הצעה
                                                    <p class="d-flex flex-wrap mr-1">
                                                        <span class="d-start"></span>
                                                        <span class="d-middle-line d-none"> - </span>
                                                        <span class="d-end ml-1"></span>
                                                    </p>
                                                </a>
                                            </h5>
                                        </div>

                                        <div id="collapseTwo" class="collapse" :class="isActiveTab(2)"
                                             role="tabpanel" aria-labelledby="headingTwo">
                                            <div class="card-block mb-3">
                                                <!-- CONTAINER-FLUID -->
                                                <div class="container-fluid">
                                                    <!-- ROW -->
                                                    <div class="row mb-5">
                                                        <div class="col-lg-12 px-lg-2">
                                                            <div v-if="loader"
                                                                 class="bg-5 d-inline-block p-1 color-white col-12 text-center">
                                                                טוען הצעות...
                                                                <span
                                                                        class="loader d-inline-block align-middle "
                                                                        role="status" aria-hidden="true"></span>
                                                            </div>
                                                            <!--show the list-->
                                                            <div v-if="list">
                                                                <div class="row ">
                                                                    <div class="col-lg-12 px-0 px-lg-0 insurance-cube-wrapper mb-3">
                                                                        <div class="p-3" v-if="list.length === 0">
                                                                            <div class="text-4 color-3 mb-3">לא התקבלו הצעות</div>
                                                                           <div class="text-5 color-4 mb-1">מלא פרטי קשר ונחזור אליך עם הצעות מעולות</div>
                                                                        <?php echo do_shortcode('[contact-form-7 id="1094" title="טופס ביטוח חיים"]');?>
                                                                        </div>
                                                                        <div v-for="(item, key ) in list"
                                                                             class="border-bottom border-color-3 my-3 col-lg-12">
                                                                            <!-- FOREACH -->
                                                                            <div class="insurance-cube">
                                                                                <div class="cube_for_mail"
                                                                                >
                                                                                    <!-- ROW -->
                                                                                    <div class="row">
                                                                                        <div class="col-lg-12 text-center text-lg-right">
                                                                                            <!-- TITLE -->
                                                                                            <span class="text-6 medium color-3 d-inline-block ins-company v-align-top">
                                                                                        {{item.company}}
                                                                                    </span>
                                                                                        </div>
                                                                                    </div>
                                                                                    <!-- TOP PART -->
                                                                                    <!-- ROW -->
                                                                                    <div class="row mb-1">
                                                                                        <!-- TOP RIGHT PART -->
                                                                                        <div class="col-8  border-color-3">
                                                                                            <div>
                                                                                                <span class="text-6 color-6">פרמיה חודשית</span>
                                                                                                <span class="text-3 color-3 medium ">
                                                                                                     {{ formatPrice(item.PriceLife)}} &#8362;
                                                                                                </span>
                                                                                           </div>
                                                                                        </div>
                                                                                        <div class="col-4">
                                                                                        </div>
                                                                                    </div><!-- ROW -->
                                                                                </div>
                                                                                <!-- ROW -->
                                                                                <div class="row mb-3">
                                                                                    <div class="col-lg-12 d-flex align-items-center justify-content-between flex-wrap">
                                                                                        <div class="d-inline-block cursor-pointer">
                                                                                            <button-details
                                                                                                    :offer_index="key"></button-details>
                                                                                        </div>
                                                                                        <!-- RECEIVE OFFER IN EMAIL -->
																						<!--
                                                                                        <div class="d-inline-block cursor-pointer ml-lg-3 receive-offer-by-email mb-1 mb-lg-0"
                                                                                             @click="toggleOpenEmail(key )">
                                                                                                <span class="custom-circle bg-5"><i
                                                                                                class="icon-envelope-01-colorwhite icon-x2 icon-x2 d-inline-block align-middle"></i></span>
                                                                                                <span class="text-custom-1 v-align-middle regular">קבל הצעה זו במייל</span>
                                                                                        </div>
                                                                                        -->
                                                                                        <!-- LEAVE PHONE NUMBER -->
                                                                                        <div class="d-inline-block cursor-pointer receive-offer-by-phone"
                                                                                             @click="toggleOpen(key )">
                                                                                                            <span class="custom-circle bg-3"><i
                                                                                                                        class="icon-phone-01-colorwhite icon-x2 icon-x2 d-inline-block align-middle"></i></span>
                                                                                            <span class="text-custom-1 v-align-middle regular"></span>
                                                                                        </div>
                                                                                        <!-- 3 BUTTONS PART -->
                                                                                        <!-- BUY INSURANCE BUTTON -->
                                                                                        <div class="d-inline-block  ">
                                                                                            <b-button
                                                                                                    v-on:click="onStep2(key)"
                                                                                                    class="btn-next s-button s-button-2 bg-5 border-color-5"
                                                                                                    type="submit"
                                                                                                    variant="primary">
                                                                                                <span>בחר הצעה</span>
                                                                                                <i class="icon-arrowleft-01-colorwhite icon-x2 d-inline-block align-middle"></i>
                                                                                            </b-button>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div :id="'collapseOne-'+key"
                                                                                     class="collapse proposal-details-content   "
                                                                                     style="font-size: 14px">
                                                                                    <div class="row pb-2">
                                                                                        <div class="col-md-12"
                                                                                             v-html="item.sub_title">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <contact-phone :selected="item"
                                                                                               :offer_index="key"
                                                                                               :subject="'פניית ביטוח חיים'"
                                                                                ></contact-phone>
                                                                                <contact-email :selected="item"
                                                                                               :offer_index="key" :subject="'פניית ביטוח חיים'"></contact-email>


                                                                            </div>
                                                                        </div>
                                                                        <!-- middle modal -->


                                                                    </div>

                                                                </div>
                                                            </div>

                                                        </div>

                                                    </div>


                                                </div>

                                            </div>


                                        </div>
                                    </div>
                                    <!-- TAB 3 -->
                                    <div class="card " v-show="activeTab==3" :class="isActiveTab(3)">
                                        <div class="card-header p-0" role="tab" id="headingOne">
                                            <h5 class="mb-0 text-5">
                                                <a data-toggle="" data-target="#collapse3"
                                                   class="d-flex align-items-center p-card color-white bg-3"
                                                   data-parent="#insurance-accordion" aria-expanded="true"
                                                   aria-controls="collapseOne">
                                                    פרטי קשר
                                                    <p class="d-flex flex-wrap mr-1">
                                                        <span class="d-start"></span>
                                                        <span class="d-middle-line d-none"> - </span>
                                                        <span class="d-end ml-1"></span>


                                                    </p>
                                                </a>
                                            </h5>
                                        </div>

                                        <div id="collapse3" class="collapse" :class="isActiveTab(3)"
                                             role="tabpanel"
                                             aria-labelledby="headingOne">
                                            <div class="card-block mb-3">

                                                <!-- CONTAINER-FLUID -->
                                                <div class="container-fluid">
                                                    <!-- ROW -->
                                                    <div class="row mb-5">
                                                        <div class="col-lg-12 px-0 px-lg-2">

                                                            <b-container class="mt-3">
                                                                <b-form @submit.prevent="onSubmit()"
                                                                        data-vv-scope="form2"
                                                                        v-if="show">

                                                                    <!-- insurance type -->
                                                                    <b-form-group
                                                                            :invalid-feedback="errors.first('form2.fullname')"
                                                                            :state="!errors.has('form2.fullname')"
                                                                            label="שם מלא">
                                                                        <b-form-input type="text" v-model="fullname"
                                                                                      name="fullname"
                                                                                      v-validate="'required'"/>
                                                                    </b-form-group>
                                                                    <!-- insurance type -->



                                                                    <!-- insurance type -->
                                                                    <b-form-group
                                                                            :invalid-feedback="errors.first('form2.email')"
                                                                            :state="!errors.has('form2.email')"
                                                                            label="אימייל">
                                                                        <b-form-input type="email" v-model="email"
                                                                                      name="email"
                                                                                      v-validate="'required'"/>
                                                                    </b-form-group>
                                                                    <!-- insurance type -->
                                                                    <b-form-group
                                                                            :invalid-feedback="errors.first('form2.phone')"
                                                                            :state="!errors.has('form2.phone')"
                                                                            label="נייד">
                                                                        <b-form-input type="tel" v-model="phone"
                                                                                      name="phone"
                                                                                      v-validate="'required|digits:10'"/>
                                                                    </b-form-group>

                                                                    <div class="col-lg-12">
                                                                        <div class="form-group">
                                                                            <input type="checkbox" v-model="tac"
                                                                                   name="tac"
                                                                                   class="form-control opacity-0"
                                                                                   id="tac"
                                                                                   v-validate="'required'">
                                                                            <label for="tac"
                                                                                   class="d-flex align-items-center checkbox-label text-5 color-6 flex-wrap">
                                                                        <span class="font-09em">אישור <a
                                                                                    href="https://www.hova.co.il/regulations/"
                                                                                    target="_blank">תנאי שימוש</a></span>
                                                                            </label>
                                                                            <span class="invalid-feedback d-block mt-2">{{ errors.first('form2.tac') }}</span>
                                                                        </div>
                                                                    </div>

                                                                    <div class="text-left">
                                                                        <b-button :disabled="loader"
                                                                                  class="btn-next s-button s-button-2 bg-5 border-color-5"
                                                                                  type="submit" variant="primary">

                                                                            <span><?php _e( 'Continue', 'sogoc' ); ?></span>
                                                                            <i v-if="!loader"
                                                                               class="icon-arrowleft-01-colorwhite icon-x2 d-inline-block align-middle"></i>
                                                                            <span v-if="loader"
                                                                                  class="loader d-inline-block align-middle"
                                                                                  role="status"
                                                                                  aria-hidden="true"></span>
                                                                        </b-button>


                                                                    </div>
                                                                </b-form>


                                                            </b-container>
                                                        </div>

                                                    </div>


                                                </div>

                                            </div>


                                        </div>
                                    </div>
                                </div><!--close #app-->
                            </div>
                        </div>
                    </div>
	</div></div>
        <div class="row justify-content-center">
					<div style="float: right" class="entry-content col-lg-4">
<?php the_content(); ?>
             </div>
             </div>
                <!-- ROW SIDEBAR -->
                <div class="row hidden-md-down mb-3">
                    <div class="col-lg-12 text-center">
                        <span><?php dynamic_sidebar( $bottom_sidebar ) ?></span>
                    </div>
                </div>
                <!-- row -->


            <!-- SIDE BANNER -->
            <div class="col-lg-1 hidden-md-down">
                <span><?php dynamic_sidebar( $left_sidebar ) ?></span>
            </div>
			</div>
		</div>
<div class="bottom-right-image">
	<?php echo wp_get_attachment_image( get_field( '_sogo_bottom_right_image' ), 'full' ); ?>
</div>
<div class="bottom-left-image">
	<?php echo wp_get_attachment_image( get_field( '_sogo_bottom_left_image' ), 'full' ); ?>
</div>


<script>
    var  app;

    Vue.use(VeeValidate); // good to go.
    jQuery(document).ready(function () {
           app = new Vue({
            el: '#app',
            data: {
                activeTab: 1,
                show: true,
                list: false,
                mobileKey: -1,
                emailKey: -1,
                CalculationType: 84300001,
                PremiumType: 84100001,
                NumberOfInsured: 84200001, // house type
                ListOfInsured: {
                    0: {
                        'Gender': null,
                        'BirthDate': null,
                        'IsSmoking': null,
                        'ID': '1',
                        'Age': '',
                    },

                },
                DesiredPeriod: 1,
                DesiredSum: null,

                params: {},
                selectedCompany: '',
                fullname: null,
                email: null,
                phone: null,
                tz: null,
                tac: null,
                loader: false,
                //   errors:{ first: function(){}, has: function(){}}


            },

            created: function () {

                this.$validator.localize('he', {
                    messages: {
                        required: function (field) {
                            return 'שדה חובה';
                        },
                        email: function (field) {
                            return 'נא להזין מייל חוקי';
                        },
                        between: function (field) {
                            return 'יש להזין ערך בין 200,000 ל 5,000,000';
                        },
                        min: function (field) {
                            return 'נא להזין מספר נייד תקין';
                        },
                    },


                })
                //     ;

                // set data


            },
            mounted: function () {
                var self = this;

                VeeValidate.Validator.extend('checkid', {
                    // Custom validation message
                    getMessage: function (field) {

                        return 'תעודת זהות לא חוקית'
                    },
                    // Custom validation rule
                    validate: function (value) {
                        // Just in case -> convert to string
                        var IDnum = value;

                        if (IDnum.length > 9) {
                            IDnum = IDnum.substring(0, 9);
                        }

                        // Validate correct input
                        if ((IDnum.length > 9) || (IDnum.length < 5))
                            return false;
                        if (isNaN(IDnum)) {
                            return false;
                        }


                        // The number is too short - add leading 0000
                        if (IDnum.length < 9) {
                            while (IDnum.length < 9) {
                                IDnum = '0' + IDnum;
                            }
                        }

                        // CHECK THE ID NUMBER
                        var mone = 0, incNum;
                        var tempIdNum = parseInt(IDnum);

                        if (tempIdNum == 0) {
                            return false;
                        }

                        for (var i = 0; i < 9; i++) {
                            incNum = Number(IDnum.charAt(i));
                            incNum *= (i % 2) + 1;
                            if (incNum > 9)
                                incNum -= 9;
                            mone += incNum;
                        }

                        return (mone % 10 == 0);


                    }

                });

                jQuery.ajax({
                    type: "GET",
                    dataType: "json",
                    url: sogo.ajaxurl,
                    data: {
                        'action': 'sogo_get_ozar_params',
                        'class': 'life',
                    },
                    success: function (response) {
                        self.params = response.data;
                    }
                });
                var startyear = (new Date).getFullYear() - 60
                var endtyear = (new Date).getFullYear() - 18
                //jQuery('.birthday-datepicker').live('focus', function () {
                    jQuery('.birthday-datepicker').datepicker({
                        changeMonth: true,
                        changeYear: true,
                        yearRange: "-60:-18",
                        defaultDate: '-18y',
                        //    yearRange:  startyear + ":" + endtyear,
                        onSelect: function (dateText) {
                            self.ListOfInsured[0].BirthDate = dateText;
                        }
                    });
                //});


            },
            methods: {
                toggleOpenEmail: function(key){
                    this.mobileKey = -1;
                    if(this.emailKey == key){
                        this.emailKey = -1;
                    }else{
                        this.emailKey = key
                    }
                },
                toggleOpen: function(key, param){
                    this.emailKey = -1;
                    if(this.mobileKey == key){
                        this.mobileKey = -1;
                    }else{
                        this.mobileKey = key
                    }
                },
                isActiveTab: function (tab) {
                    if (this.activeTab === tab) {
                        return "card-current show";
                    }
                    if (this.activeTab > tab) {
                        return "card-visited";
                    }
                },
                showDone: function (tab) {

                    if (tab >= this.activeTab) {

                    }
                },
                formatPrice: function (value) {
                    var val = (value / 1).toFixed(0);
                    return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                },
                onStep1: function () {
                    this.$validator.validateAll('form1').then(function (result) {
                        console.log(result);
                        if (result) { // valid form
                            app.loader = true;
                            app.activeTab = 2;
                            app.list= {};
                            jQuery.ajax({
                                type: "POST",
                                dataType: "json",
                                url: sogo.ajaxurl,
                                data: {
                                    'action': 'sogo_get_life',
                                    'order_data': JSON.stringify(app.$data)
                                    //'d': 1
                                },
                                success: function (response) {
                                    app.list = response.data;
                                    app.loader = false;
                                    jQuery("html, body").stop().animate({scrollTop:0}, 500, 'swing', function() { });
                                }
                            });

                        }else{
                            jQuery("html, body").stop().animate({scrollTop:0}, 500, 'swing', function() { });
                        }

                    });
                },
                onStep2: function (key) {
                    app.selectedCompany = JSON.stringify(app.list[key]);
                    app.activeTab = 3;
                    jQuery("html, body").stop().animate({scrollTop:0}, 500, 'swing', function() { });

                },
                onSubmit: function () {
                    this.$validator.validateAll('form2').then(function (result) {
                        console.log(result);
                        if (result) { // valid form
                            app.loader = true;
                            jQuery.ajax({
                                type: "POST",
                                dataType: "json",
                                url: sogo.ajaxurl,
                                data: {
                                    'action': 'sogo_dira_order',
                                    // 'company': selectedCompany,
                                    'order_data': JSON.stringify(app.$data)
                                    //'d': 1
                                },
                                success: function (response) {
                                    location.href = app.params.thx

                                }
                            });

                        }else{
                            jQuery("html, body").stop().animate({scrollTop:0}, 500, 'swing', function() { });
                        }

                    });
                }


            }
        });


    });





</script>


<?php get_footer(); ?>
