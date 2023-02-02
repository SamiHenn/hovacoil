<?php
/**
 * Template Name: Health Insurance old
 */
get_header(); ?>
<!--BREADCRUMBS-->
<?php include "templates/content-breadcrumbs.php"; ?>
<div class="page-insurance-compare-1 pb-5">
    <section class="section-insurance-compare-1">
        <!-- CONTAINER-FLUID -->
        <div class="container-fluid">
            <!-- ROW TITLE-->
            <div class="row justify-content-center mb-3">
                <div class="col-lg-8">
                    <h1 class="text-1 color-4"><?php the_title(); ?></h1>
                </div>
            </div>
            <!-- ROW -->
            <div class="row justify-content-center">
                <div class="col-lg-10 col-xl-8">
                    <div id="app">
                        <div id="insurance-accordion" role="tablist" aria-multiselectable="true">
                            <!-- TAB 1 -->
                            <div class="card " :class="isActiveTab(1)">
                                <div class="card-header p-0" role="tab" id="headingOne">
                                    <h5 class="mb-0 text-5">
                                        <a data-toggle="collapse" data-target="#collapseOne"
                                           class="cursor-pointer d-flex align-items-center p-card"
                                           data-parent="#insurance-accordion" aria-expanded="true"
                                           aria-controls="collapseOne">

                                            <i class="icon-check-01-colorwhite icon-x2 ml-1  " :class="showDone(1)"></i>
                                            בחר ביטוח
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
                                                        <b-form @submit="onStep1" v-if="show"
                                                                @submit.prevent="$validator.validateAll()">
                                                            <!-- Gender -->
                                                            <b-form-group :invalid-feedback="errors.first('Gender')"
                                                                          :state="!errors.has('Gender')"
                                                                          label="מין המבוטח">
                                                                <b-form-select v-model="Gender"
                                                                               v-validate="'required'"
                                                                               name="Gender"
                                                                               :options="params.Gender">
                                                            </b-form-group>
                                                            <b-form-group
                                                                    label="תאריך לידה">
                                                                <b-form-input type="date"
                                                                              v-model="Age"
                                                                              :invalid-feedback="errors.first('Age')"
                                                                              :state="!errors.has('Age')"
                                                                              v-validate="'required'"
                                                                              name="Age"
                                                                >
                                                            </b-form-group>
                                                            <!-- suites type -->
                                                            <b-form-group
                                                                    label="האם הביטוח נרכש לצורך משכנתה?">
                                                                <b-form-checkbox value="83000001"
                                                                                 v-model="SelectedInsuranceTypes"
                                                                                 name="SelectedInsuranceTypes[]">ניתוחים
                                                                </b-form-checkbox>
                                                                <b-form-checkbox value="83000002"
                                                                                 v-model="SelectedInsuranceTypes"
                                                                                 name="SelectedInsuranceTypes[]">השתלות
                                                                </b-form-checkbox>
                                                                <b-form-checkbox value="83000004"
                                                                                 v-model="SelectedInsuranceTypes"
                                                                                 name="SelectedInsuranceTypes[]">תרופות
                                                                </b-form-checkbox>

                                                            </b-form-group>
                                                            <div class="text-left">
                                                                <b-button
                                                                        class="btn-next s-button s-button-2 bg-5 border-color-5"
                                                                        type="submit" variant="primary">
                                                                    <span><?php _e( 'Continue', 'sogoc' ); ?></span>
                                                                    <i class="icon-arrowleft-01-colorwhite icon-x2 d-inline-block align-middle"></i>
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
                            <div class="card" :class="isActiveTab(2)">
                                <div class="card-header p-0" role="tab" id="headingTwo">
                                    <h5 class="mb-0 text-5">
                                        <a data-toggle="collapse" data-target="#collapseTwo"
                                           class="cursor-pointer d-flex align-items-center p-card"
                                           data-parent="#insurance-accordion" aria-expanded="true"
                                           aria-controls="collapseOne">
                                            <i class="icon-check-01-colorwhite icon-x2 ml-1 d-none"></i>
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
                                                <div class="col-lg-12 px-0 px-lg-2">
                                                    <!--show the list-->
                                                    <div v-if="list">
                                                        <div class="row  ">
                                                            <div class="col-lg-12 px-0 px-lg-2 insurance-cube-wrapper mb-3">
                                                                <div v-for="(item, key ) in list.InsuranceCompanies"
                                                                     class="border-bottom border-color-3">
                                                                    <!-- FOREACH -->
                                                                    <div class="insurance-cube pt-1 px-2">
                                                                        <div class="cube_for_mail">
                                                                            <!-- ROW -->
                                                                            <div class="row">
                                                                                <div class="col-lg-12 text-center text-lg-right">
                                                                                    <!-- TITLE -->
                                                                                    <span class="text-6 medium color-3 d-inline-block ins-company v-align-top">
                                                                                        {{item.MainCompanyName}}
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                            <!-- TOP PART -->
                                                                            <!-- ROW -->
                                                                            <div class="row mb-1">
                                                                                <!-- TOP RIGHT PART -->
                                                                                <div class="col-6 col-lg-3  border-color-3">
                                                                                    <!-- TITLE -->
                                                                                    <span class="text-6 color-6 d-inline-block v-align-top">
                                                                                        {{item.CompanyName}}
                                                                                    </span>
                                                                                    <!-- PRICE -->
                                                                                    <div>
                                                                                        <span class="text-6 color-6">סה"כ</span>
                                                                                        <span class="text-3 color-3 medium total">
                                                                                                {{ formatPrice(item.Price) }}
                                                                                        </span>
                                                                                        <span class="text-p color-3 medium">₪</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div><!-- ROW -->
                                                                        </div>
                                                                        <div :id="'collapseOne-'+key"
                                                                             class="collapse proposal-details-content text-4 ">
                                                                            <div class="row">
                                                                                <div class="col-4 " v-if="SelectedInsuranceTypes.includes('83000002')">
                                                                                    <h2 class="text-4 color-3">השתלות</h2>
                                                                                    <ul v-for="remark in item.ImplantsBullets">
                                                                                        <li>{{ remark }}</li>
                                                                                    </ul>
                                                                                </div>
                                                                                <div class="col-4"  v-if="SelectedInsuranceTypes.includes('83000004')">
                                                                                    <h2 class="text-4 color-3">תרופות</h2>
                                                                                    <ul v-for="remark in item.MedicationsBullets">
                                                                                        <li>{{ remark }}</li>
                                                                                    </ul>
                                                                                </div>
                                                                                <div class="col-4"  v-if="SelectedInsuranceTypes.includes('83000001')">
                                                                                    <h2 class="text-4 color-3">ניתוחים</h2>
                                                                                    <ul v-for="remark in item.SurgeriesBullets">
                                                                                        <li>{{ remark }}</li>
                                                                                    </ul>
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                        <!-- ROW -->
                                                                        <div class="row mb-2">
                                                                            <div class="col-lg-12 d-flex align-items-center justify-content-between">
                                                                                <button-details  :offer_index="key"></button-details>
                                                                                <!-- 3 BUTTONS PART -->
                                                                                <!-- BUY INSURANCE BUTTON -->
                                                                                <div>
                                                                                    <b-button v-on:click="onStep2(key)"
                                                                                              class="btn-next s-button s-button-2 bg-5 border-color-5"
                                                                                              type="submit"
                                                                                              variant="primary">
                                                                                        <span> המשך הזמנה</span>
                                                                                        <i class="icon-arrowleft-01-colorwhite icon-x2 d-inline-block align-middle"></i>
                                                                                    </b-button>
                                                                                </div>
                                                                            </div>

                                                                        </div>

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
                            <div class="card " :class="isActiveTab(3)">
                                <div class="card-header p-0" role="tab" id="headingOne">
                                    <h5 class="mb-0 text-5">
                                        <a data-toggle="collapse" data-target="#collapse3"
                                           class="cursor-pointer d-flex align-items-center p-card"
                                           data-parent="#insurance-accordion" aria-expanded="true"
                                           aria-controls="collapseOne">
                                            <i class="icon-check-01-colorwhite icon-x2 ml-1 " :class="showDone(3)"></i>
                                            פרטים אישיים
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
                                                        <b-form @submit="onSubmit" v-if="show"
                                                                @submit.prevent="$validator.validateAll()">

                                                            <!-- insurance type -->
                                                            <b-form-group :invalid-feedback="errors.first('fullname')"
                                                                          :state="!errors.has('fullname')"
                                                                          label="שם מלא">
                                                                <b-form-input type="text" v-model="fullname"
                                                                              name="fullname"/>
                                                            </b-form-group>

                                                            <!-- insurance type -->
                                                            <b-form-group :invalid-feedback="errors.first('email')"
                                                                          :state="!errors.has('email')"
                                                                          label="אימייל">
                                                                <b-form-input type="email" v-model="email"
                                                                              name="email"/>
                                                            </b-form-group>
                                                            <!-- insurance type -->
                                                            <b-form-group :invalid-feedback="errors.first('phone')"
                                                                          :state="!errors.has('phone')"
                                                                          label="נייד">
                                                                <b-form-input type="tel" v-model="phone"
                                                                              name="phone"/>
                                                            </b-form-group>


                                                            <div class="text-left">
                                                                <b-button
                                                                        class="btn-next s-button s-button-2 bg-5 border-color-5"
                                                                        type="submit" variant="primary">
                                                                    <span><?php _e( 'Continue', 'sogoc' ); ?></span>
                                                                    <i class="icon-arrowleft-01-colorwhite icon-x2 d-inline-block align-middle"></i>
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
                <!-- ROW SIDEBAR -->
                <div class="row hidden-md-down mb-3">
                    <div class="col-lg-12 text-center">
                        <span><?php dynamic_sidebar( $bottom_sidebar ) ?></span>
                    </div>
                </div>
                <!-- row -->
                <div class="row">
                    <div class="col-12">
                        <div class="entry-content">
							<?php the_content(); ?>
                        </div>
                    </div>
                </div>
            </div>
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
    Vue.use(VeeValidate); // good to go.

    jQuery(document).ready(function () {
        var app = new Vue({
            el: '#app',
            data: {
                activeTab: 1,
                show: true,
                list: false,
                Age: '',
                Gender: '',
                SelectedInsuranceTypes: [],
                params: {},
                selectedCompany: '',
                fullname: '',
                email: '',
                phone: '',

            },

            created: function () {
                VeeValidate.Validator.extend('verify_total', {
                    // Custom validation message
                    getMessage: function (field) {
                        return 'נא להזין סכום שהוא 5000 * מ"ר'
                    },
                    // Custom validation rule
                    validate: function (value) {
                        return value && value >= (app.$data.house_sm * 5000);
                    }

                });
            },
            mounted: function () {
                var self = this;
                jQuery.ajax({
                    type: "GET",
                    dataType: "json",
                    url: sogo.ajaxurl,
                    data: {
                        'action': 'sogo_get_ozar_params',
                        'class': 'health',
                    },
                    success: function (response) {
                        self.params = response.data;
                    }
                });
            },
            methods: {
                isActiveTab: function (tab) {
                    if (this.activeTab === tab) {
                        return "card-current show";
                    }
                    if (this.activeTab > tab) {
                        console.log(this.activeTab > tab);
                        console.log(this.activeTab);
                        return "card-visited";
                    }
                },
                showDone: function (tab) {

                    if (tab >= this.activeTab) {
                        console.log(tab);
                        console.log(this.activeTab);

                        return "d-none";
                    }
                },
                formatPrice(value) {
                    var val = (value / 1).toFixed(2);
                    return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                },
                onStep1() {
                    this.$validator.validateAll().then(function (result) {
                        if (result) { // valid form
                            jQuery.ajax({
                                type: "POST",
                                dataType: "json",
                                url: sogo.ajaxurl,
                                data: {
                                    'action': 'sogo_get_health',
                                    'order_data': JSON.stringify(app.$data)
                                    //'d': 1
                                },
                                success: function (response) {
                                    app.list = response.data;
                                    app.activeTab = 2;
                                }
                            });

                        }

                    });
                },
                onStep2(key) {
                    app.selectedCompany = JSON.stringify(app.list[key]);
                    app.activeTab = 3;
                },
                onSubmit() {
                    this.$validator.validateAll().then(function (result) {
                        if (result) { // valid form
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
                                    alert('thx');

                                }
                            });

                        }

                    });
                }


            }
        });
    });


    /**
     * components  - need to move to seperate file
     */
// Define a new component called button-counter



</script>
<?php get_footer(); ?>
