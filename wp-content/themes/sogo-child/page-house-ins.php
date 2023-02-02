<?php
/**
 * Template Name: House Insurance
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
<div id="samibg" class="page-insurance-compare-1 ozar pb-5">
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
                <div class="col-lg-4">
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
                                                                <b-form @submit.prevent="onStep1( )" v-if="show"
                                                                        data-vv-scope="form1"
                                                                >
                                                                    <div class="row">
                                                                        <div class="col-md-12 mb-3">
                                                                            <div class="s-radio-wrapper">

                                                                                <label class="text-5 color-6 d-inline-block mb-1">
                                                                                    סוג הביטוח המבוקש
                                                                                </label>

                                                                                <div class="d-flex">

                                                                                    <input type="radio"
                                                                                           class="form-radio-input opacity-0 p-absolute"
                                                                                           name="coverage"
                                                                                           v-model="coverage"
                                                                                           id="coverage1"
                                                                                           value="80100001"
                                                                                           data-val="under-year"
                                                                                           v-validate="'required'">

                                                                                    <label class="form-radio-label radio-btn-style p-relative text-5 flex-grow-1"
                                                                                           for="coverage1">
                                                                                        מבנה
                                                                                    </label>

                                                                                    <input type="radio"
                                                                                           class="form-radio-input opacity-0"
                                                                                           name="coverage"
                                                                                           v-model="coverage"
                                                                                           id="coverage2"
                                                                                           value="80100002"
                                                                                           data-val="above-year"
                                                                                           v-validate="'required'">

                                                                                    <label class="form-radio-label radio-btn-style p-relative text-5 flex-grow-1"
                                                                                           for="coverage2">
                                                                                        תכולה
                                                                                    </label>
                                                                                    <input type="radio"
                                                                                           class="form-radio-input opacity-0"
                                                                                           name="coverage"
                                                                                           v-model="coverage"
                                                                                           id="coverage3"
                                                                                           value="80100003"
                                                                                           data-val="above-year"
                                                                                           v-validate="'required'">

                                                                                    <label class="form-radio-label radio-btn-style p-relative text-5 flex-grow-1"
                                                                                           for="coverage3">
                                                                                        מבנה ותכולה
                                                                                    </label>

                                                                                </div>
                                                                                <span class="invalid-feedback d-block mt-2">{{ errors.first('form1.coverage') }}</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- insurance type -->


                                                                    <!-- house type -->
                                                                    <b-form-group
                                                                            :invalid-feedback="errors.first('form1.mtype')"
                                                                            :state="!errors.has('form1.mtype')"
                                                                            label="סוג מבנה וקומה">
                                                                        <b-form-select v-model="mtype"
                                                                                       v-validate="'required'"
																					   style="height: 45px"
                                                                                       name="mtype"
                                                                                       :options="params.mtype">
                                                                        </b-form-select>
                                                                    </b-form-group>

                                                                    <!--Middle floor only if selected in prev: קומת בניים-->
                                                                    <b-form-group v-if="mtype=='80500004'"
                                                                                  :invalid-feedback="errors.first('form1.mtype_parameter')"
                                                                                  :state="!errors.has('form1.mtype_parameter')"
                                                                                  label="קומת ביניים">
                                                                        <b-form-input type="number"
                                                                                      v-model="mtype_parameter"
                                                                                      v-validate="'required|between:1,50'"
                                                                                      name="mtype_parameter"/>
                                                                    </b-form-group>

                                                                    <!-- house age-->
                                                                    <b-form-group
                                                                            v-if="coverage && coverage !=='80100002'"
                                                                            :invalid-feedback="errors.first('form1.mage_parameter')"
                                                                            :state="!errors.has('form1.mage_parameter')"
                                                                            label="גיל המבנה בשנים">
                                                                        <b-form-input type="number"
                                                                                      v-model="mage_parameter"
                                                                                      v-validate="'required|between:1,100'"
                                                                                      name="mage_parameter"/>
                                                                    </b-form-group>
                                                                    <!-- house square meters-->
                                                                    <b-form-group
                                                                            v-if="coverage && coverage !=='80100002'"
                                                                            :invalid-feedback="errors.first('form1.house_sm')"
                                                                            :state="!errors.has('form1.house_sm')"
                                                                            label='מה שטח המבנה ברוטו (מ"ר)?'>
                                                                        <b-form-input type="number" v-model="house_sm"
                                                                                      v-validate="'required|between:20,500'"
                                                                                      name="house_sm"/>
                                                                    </b-form-group>

                                                                    <!-- house insurance total-->
                                                                    <b-form-group
                                                                            v-if="coverage && coverage !=='80100002'"
                                                                            :invalid-feedback="errors.first('form1.msum')"
                                                                            :state="!errors.has('form1.msum')"
                                                                            label='סכום ביטוח המבנה בש"ח'>
                                                                        <b-form-input type="number" v-model="msum"
                                                                                      name="msum"
                                                                                      v-validate="'required|verify_total'"/>
                                                                    </b-form-group>

                                                                    <!-- house hold insurance total-->
                                                                    <b-form-group
                                                                            v-if="coverage && coverage !=='80100001'"
                                                                            :invalid-feedback="errors.first('form1.tsum')"
                                                                            :state="!errors.has('form1.tsum')"
                                                                            label='סכום ביטוח התכולה בש"ח'>
                                                                        <b-form-input type="number"
                                                                                      key="9999"
                                                                                      v-model="tsum"
                                                                                      name="tsum"
                                                                                      v-validate="'required|between:1,400000'"
                                                                        />
                                                                    </b-form-group>

                                                                    <!-- house type -->
                                                                    <b-form-group
                                                                            v-if="coverage && coverage !=='80100002'"
                                                                            :invalid-feedback="errors.first('form1.maim')"
                                                                            :state="!errors.has('form1.maim')"
                                                                            label="כיסוי לנזקי מים">
                                                                        <b-form-select v-model="maim"
                                                                                       :options="params.maim"
																					   style="height: 45px"
                                                                                       name="maim"
                                                                                       v-validate="'required|verify_plump'">

                                                                        </b-form-select>
                                                                    </b-form-group>

                                                                    <!-- suites type -->
                                                                    <b-form-group
                                                                            v-if="coverage && coverage !=='80100002'"
                                                                            :invalid-feedback="errors.first('form1.mtvia')"
                                                                            :state="!errors.has('form1.mtvia')"
                                                                            label="האם הוגשו תביעות בשנים האחרונות בביטוח מבנה? (למעט בגין כיסוי לנזקי מים)">
                                                                        <b-form-select v-model="mtvia"
                                                                                       :options="params.mtvia"
																					   style="height: 45px"
                                                                                       name="mtvia"
                                                                                       :key="mtiva1"
                                                                                       v-validate="'required'">

                                                                        </b-form-select>
                                                                    </b-form-group>
                                                                    <!-- suites type -->
                                                                    <b-form-group
                                                                            v-if="coverage && coverage !=='80100001'"
                                                                            :invalid-feedback="errors.first('form1.ttvia')"
                                                                            :state="!errors.has('form1.ttvia')"
                                                                            label="האם הוגשו תביעות בשנים האחרונות בביטוח תכולה?">
                                                                        <b-form-select v-model="ttvia"
																					   style="height: 45px"
                                                                                       name="ttvia"
                                                                                       :key="ttiva1"
                                                                                       :options="params.ttvia"
                                                                                       v-validate="'required'">

                                                                        </b-form-select>
                                                                    </b-form-group>


                                                                    <!-- suites type -->
                                                                    <div class="row">
                                                                        <div class="col-md-6 mb-3">
                                                                            <div class="s-radio-wrapper"
                                                                                 v-if="coverage && coverage !=='80100002'">

                                                                                <label class="text-5 color-6 d-inline-block mb-1">
                                                                                    האם הביטוח נרכש לצורך משכנתה?
                                                                                </label>

                                                                                <div class="d-flex">

                                                                                    <input type="radio"
                                                                                           class="form-radio-input opacity-0 p-absolute"
                                                                                           name="mashkanta"
                                                                                           v-model="mashkanta"
                                                                                           id="mashkanta1" value="0"
                                                                                           data-val="under-year"
                                                                                           v-validate="'required'">

                                                                                    <label class="form-radio-label radio-btn-style p-relative text-5 flex-grow-1"
                                                                                           for="mashkanta1">
                                                                                        לא
                                                                                    </label>

                                                                                    <input type="radio"
                                                                                           class="form-radio-input opacity-0"
                                                                                           name="mashkanta"
                                                                                           v-model="mashkanta"
                                                                                           id="mashkanta2" value="1"
                                                                                           data-val="above-year"
                                                                                           v-validate="'required'">

                                                                                    <label class="form-radio-label radio-btn-style p-relative text-5 flex-grow-1"
                                                                                           for="mashkanta2">
                                                                                        כן
                                                                                    </label>

                                                                                </div>
                                                                                <span class="invalid-feedback d-block mt-2">{{ errors.first('form1.mashkanta') }}</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>


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
                                                                 class="bg-5 d-inline-block p-1 color-white">
                                                                טוען...
                                                                <span
                                                                        class="loader d-inline-block align-middle "
                                                                        role="status" aria-hidden="true"></span>
                                                            </div>
                                                            <!--show the list-->
                                                            <div v-if="list">
                                                                <div class="row  ">
                                                                    <div class="col-lg-12 px-0 px-lg-0 insurance-cube-wrapper my-3">
                                                                        <div class="p-3" v-if="list.length === 0">
                                                                            <div class="text-4 color-3 mb-3">לא התקבלו הצעות</div>
                                                                           <div class="text-5 color-4 mb-1">מלא פרטי קשר ונחזור אליך עם הצעות מעולות</div>			                                                                    <?php echo do_shortcode('[contact-form-7 id="1103" title="טופס ביטוח דירה"]');?>
                                                                        </div>
                                                                        <div v-for="(item, key ) in list"
                                                                             class="border-bottom border-color-3 col-12 mb-3">
                                                                            <!-- FOREACH -->
                                                                            <div class="insurance-cube">
                                                                                <div class="cube_for_mail" >
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
                                                                                            <!-- TITLE -->
                                                                                            <div class="text-6 color-6 d-inline-block v-align-top"
                                                                                                 v-html="item.sub_title">
                                                                                                >

                                                                                            </div>
                                                                                            <div>
                                                                                                <span class="text-6 color-6">פרמיה שנתית</span>
                                                                                                <span class="text-3 color-3 medium ">
                                                                                                      {{ formatPrice(item.Price) }} &#8362;
                                                                                                </span>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-4">
                                                                                        </div>
                                                                                    </div><!-- ROW -->
                                                                                </div>

                                                                                <!-- ROW -->
                                                                                <div class="row mb-2">
                                                                                    <div class="col-lg-12 d-flex align-items-center justify-content-between flex-wrap">
                                                                                        <div class="d-inline-block cursor-pointer">
                                                                                            <button-details
                                                                                                    :offer_index="key"></button-details>
                                                                                        </div>
                                                                                        <!-- RECEIVE OFFER IN EMAIL -->
                                                                                         <!--<div class="d-inline-block cursor-pointer ml-lg-3 receive-offer-by-email mb-1 mb-lg-0"
                                                                                             @click="toggleOpenEmail(key )">
                                                                                                <span class="custom-circle bg-5"><i
                                                                                                            class="icon-envelope-01-colorwhite icon-x2 icon-x2 d-inline-block align-middle"></i></span>
                                                                                            <span class="text-custom-1 v-align-middle regular">קבל הצעה זו במייל</span>
                                                                                        </div>-->
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
                                                                                     class="collapse proposal-details-content ">
                                                                                    <div class="row text-6"
                                                                                         v-for="remark in item.RateRemarks">
                                                                                        <div style="border-bottom: 1px solid #c0c0c0" class="col-md-3 color-3 my-1 py-1">
                                                                                            {{remark.RemarkTitle }}
                                                                                        </div>
                                                                                        <div style="border-bottom: 1px solid #c0c0c0" class="col-md-8 color-6 my-1 py-1">
{{
                                                                                            remark.RemarkBody}}
                                                                                        </div>
                                                                                    </div>

                                                                                </div>


                                                                                <contact-phone :selected="item"
                                                                                               :offer_index="key"
                                                                                               :subject="'פניית ביטוח חיים'"
                                                                                ></contact-phone>
                                                                                <contact-email :selected="item"
                                                                                               :offer_index="key"
                                                                                               :subject="'פניית ביטוח חיים'"></contact-email>


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
                                                   class="d-flex align-items-center p-card bg-3 color-white"
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
                </div>
<div class="row justify-content-center">
<div class="entry-content col-lg-4">
<?php the_content(); ?>
             </div>                <!-- ROW SIDEBAR -->
                <div class="row hidden-md-down mb-3">
                    <div class="col-lg-12 text-center">
                        <span><?php dynamic_sidebar( $bottom_sidebar ) ?></span>
                    </div>
                </div>
                <!-- row -->

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
    var app;
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
                coverage: null, //
                mtype: null, // house type
                mtype_parameter: null, // floor
                mage_parameter: null, // house age
                house_sm: null,
                mtvia: null,
                mtiva1: null,
                ttiva1: null,
                ttvia: null,
                msum: null, // סכום ביטוח המבנה בש''ח
                tsum: null, // סכום ביטוח התכולה בש''ח
                maim: 80600001,
                mashkanta: null,
                params: {},
                selectedCompany: '',
                fullname: '',
                email: '',
                phone: '',
                tac: null,
                loader: false,
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
                        between: function (field, args) {
                            console.log(args);
                            return 'יש להזין ערך בין ' + args[0] + ' ל-' + args[1]
                        },
                        min: function (field) {
                            return 'נא להזין מספר נייד תקין';
                        },
                    },


                }),

                    VeeValidate.Validator.extend('verify_total', {
                        // Custom validation message
                        getMessage: function (field) {
                            var message = app.formatPrice(app.$data.house_sm * 5000, 0);
                            return 'מינימום ' + message
                        },
                        // Custom validation rule
                        validate: function (value) {
                            return value && value >= (app.$data.house_sm * 5000);
                        }

                    });

                VeeValidate.Validator.extend('verify_plump', {
                    // Custom validation message
                    getMessage: function (field) {

                        return 'בביטוח הנרכש לצורך משכנתה, יש לבחור בשרברב מטעם חברת הביטוח או בשרברב לבחירת המבוטח';
                    },
                    // Custom validation rule
                    validate: function (value) {

                        if (app) {
                            if (app.$data.mashkanta) {
                               // console.log(app.$data.mashkanta   );

                                if (app.$data.mashkanta == 1){
                                    console.log(  value  );
                                    return value != 80600003;
                                }
                               return value;
                            }
                            return true;
                        }
                        return false;
                    }

                });

                // set data


            },
            mounted: function () {
                var self = this;
                jQuery.ajax({
                    type: "GET",
                    dataType: "json",
                    url: sogo.ajaxurl,
                    data: {
                        'action': 'sogo_get_ozar_params',
                        'class': 'dira',
                    },
                    success: function (response) {
                        self.params = response.data;
                    }
                });
            }
            ,
            methods: {
                toggleOpenEmail: function (key) {
                    this.mobileKey = -1;
                    if (this.emailKey == key) {
                        this.emailKey = -1;
                    } else {
                        this.emailKey = key
                    }
                },
                toggleOpen: function (key, param) {
                    this.emailKey = -1;
                    if (this.mobileKey == key) {
                        this.mobileKey = -1;
                    } else {
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

                        return "d-none";
                    }
                },
                formatPrice: function (value) {
                    var val = (value / 1).toFixed(0);
                    return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                },
                onStep1() {

                    this.errors.clear();
                    this.$validator.validateAll("form1").then(function (result) {
                        if (result) { // valid form
                            app.loader = true;
                            app.activeTab = 2;
                            jQuery.ajax({
                                type: "POST",
                                dataType: "json",
                                url: sogo.ajaxurl,
                                data: {
                                    'action': 'sogo_get_dira',
                                    'order_data': JSON.stringify(app.$data)
                                    //'d': 1
                                },
                                success: function (response) {
                                    app.list = response.data;
                                    app.loader = false;
                                    jQuery("html, body").stop().animate({scrollTop: 0}, 500, 'swing', function () {
                                    });
                                }
                            });

                        } else {
                            jQuery("html, body").stop().animate({scrollTop: 0}, 500, 'swing', function () {
                            });
                        }

                    });
                }
                ,
                onStep2(key) {
                    app.selectedCompany = JSON.stringify(app.list[key]);
                    app.activeTab = 3;
                    jQuery("html, body").stop().animate({scrollTop: 0}, 500, 'swing', function () {
                    });
                }
                ,
                onSubmit() {
                    this.$validator.validateAll('form2').then(function (result) {
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

                        } else {
                            jQuery("html, body").stop().animate({scrollTop: 0}, 500, 'swing', function () {
                            });
                        }

                    });
                }


            }
        });
    })
    ;


</script>
<?php get_footer(); ?>
