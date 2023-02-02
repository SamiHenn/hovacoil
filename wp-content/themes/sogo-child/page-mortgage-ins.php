<?php
/**
 * Template Name: Mortgage Insurance
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
                                <!--<a title="דברו איתנו" class="color-3 text-5 text-center cursor-pointer" onclick="samiShowForm()">דברו איתנו</a>-->
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
                                    <div class="card " v-show="activeTab==1" :class="isActiveTab(1)" style="border-bottom: 0px solid; border-radius: 10px;">
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
                                                                    <div class="row d-none">
                                                                        <div class="col-md-6 mb-3">
                                                                            <div class="s-radio-wrapper">
                                                                                <label class="text-5 color-6 d-inline-block mb-1">
                                                                                    סוג משכנתא
                                                                                </label>
                                                                                <div class="d-flex">
                                                                                    <input checked type="radio"
                                                                                           class="form-radio-input opacity-0 p-absolute"
                                                                                           name="maskantaType"
                                                                                           v-model="maskantaType"
                                                                                           id="maskantaType1"
                                                                                           value="חדשה"
                                                                                           data-val="חדשה" v-validate="'required'">
                                                                                    <label class="form-radio-label radio-btn-style p-relative text-5 flex-grow-1"
                                                                                           for="maskantaType1">
                                                                                        משכנתא חדשה
                                                                                    </label>
                                                                                    &nbsp;
                                                                                    <input type="radio"
                                                                                           class="form-radio-input opacity-0 p-absolute"
                                                                                           name="maskantaType"
                                                                                           v-model="maskantaType"
                                                                                           id="maskantaType2"
                                                                                           value="84200002"
                                                                                           data-val="קיימת" v-validate="'required'">
                                                                                    <label class="form-radio-label radio-btn-style p-relative text-5 flex-grow-1"
                                                                                           for="maskantaType2">
                                                                                        משכנתא קיימת
                                                                                    </label>
                                                                                </div>
                                                                                <span class="invalid-feedback d-block mt-2">{{ errors.first('form1.maskantaType') }}</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-md-9 mb-3">
                                                                            <div class="s-radio-wrapper">

                                                                                <label class="text-5 color-6 d-inline-block mb-1">
                                                                                   סוג הביטוח?
                                                                                </label>

                                                                                <div class="d-flex">

                                                                             <!--       <input type="radio"
                                                                                           class="form-radio-input opacity-0 p-absolute"
                                                                                           name="insType"
                                                                                           v-model="insType"
                                                                                           id="insType1"
                                                                                           value="1"
                                                                                           data-val="under-year"
                                                                                           v-validate="'required'">

                                                                                    <label class="form-radio-label radio-btn-style p-relative text-5 flex-grow-1"
                                                                                           for="insType1">
                                                                                        חיים ומבנה
                                                                                    </label>
                                                                              -->

                                                                                    <input type="radio"
                                                                                           class="form-radio-input opacity-0"
                                                                                           name="insType"
                                                                                           v-model="insType"
                                                                                           id="insType2"
                                                                                           value="2"
                                                                                           data-val="above-year"
                                                                                           v-validate="'required'">

                                                                                    <label class="form-radio-label radio-btn-style p-relative text-5 flex-grow-1"
                                                                                           for="insType2">
                                                                                        ביטוח חיים למשכנתא
                                                                                    </label>
                                                                                    <input type="radio"
                                                                                           class="form-radio-input opacity-0"
                                                                                           name="insType"
                                                                                           v-model="insType"
                                                                                           id="insType3"
                                                                                           value="3"
                                                                                           data-val="above-year"
                                                                                           v-validate="'required'">

                                                                                    <label class="form-radio-label radio-btn-style p-relative text-5 flex-grow-1"
                                                                                           for="insType3">
                                                                                         ביטוח מבנה למשכנתא
                                                                                    </label>

                                                                                </div>
                                                                                <span class="invalid-feedback d-block mt-2">{{ errors.first('form1.insType') }}</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="insOption1" v-if="insType !=='3'">
                                                                        <div class="row">
                                                                            <div class="col-md-6 mb-3">
                                                                                <div class="s-radio-wrapper">
                                                                                    <label class="text-5 color-6 d-inline-block mb-1">
                                                                                        מספר מבוטחים
                                                                                    </label>
                                                                                    <div class="d-flex">
                                                                                        <input type="radio"
                                                                                               class="form-radio-input opacity-0 p-absolute"
                                                                                               name="NumberOfInsured"
                                                                                               v-model="NumberOfInsured"
                                                                                               id="NumberOfInsured1"
                                                                                               value="84200001"
                                                                                               data-val="84200001" v-validate="'required'">
                                                                                        <label class="form-radio-label radio-btn-style p-relative text-5 flex-grow-1"
                                                                                               for="NumberOfInsured1">
                                                                                            מבוטח 1
                                                                                        </label>
                                                                                        &nbsp;
                                                                                        <input type="radio"
                                                                                               class="form-radio-input opacity-0 p-absolute"
                                                                                               name="NumberOfInsured"
                                                                                               v-model="NumberOfInsured"
                                                                                               id="NumberOfInsured2"
                                                                                               value="84200002"
                                                                                               data-val="84200002" v-validate="'required'">
                                                                                        <label class="form-radio-label radio-btn-style p-relative text-5 flex-grow-1"
                                                                                               for="NumberOfInsured2">
                                                                                            2 מבוטחים
                                                                                        </label>
                                                                                    </div>
                                                                                    <span class="invalid-feedback d-block mt-2">{{ errors.first('form1.NumberOfInsured') }}</span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="person1 p-2 bg-8 border-top border-color-7"
                                                                             v-if="NumberOfInsured">
                                                                            <!-- First person-->
                                                                            <h2 class="text-5 color-4 pb-1 border-bottom border-color-5">מבוטח
                                                                                ראשון</h2>
                                                                            <div class="row">
                                                                                <div class="col-md-6 mb-3">
                                                                                    <div class="s-radio-wrapper">
                                                                                        <label class="text-5 color-6 d-inline-block mb-1">מין
                                                                                            המבוטח</label>
                                                                                        <div class="d-flex">
                                                                                            <input type="radio"
                                                                                                   class="form-radio-input opacity-0 p-absolute"
                                                                                                   name="ListOfInsured[0].Gender"
                                                                                                   v-model="ListOfInsured[0].Gender"
                                                                                                   id="Gender1"
                                                                                                   value="84400001"
                                                                                                   data-val="84400001" v-validate="'required'">
                                                                                            <label class="form-radio-label radio-btn-style p-relative text-5 flex-grow-1"
                                                                                                   for="Gender1">
                                                                                                זכר
                                                                                            </label>
                                                                                            &nbsp;
                                                                                            <input type="radio"
                                                                                                   class="form-radio-input opacity-0 p-absolute"
                                                                                                   name="ListOfInsured[0].Gender"
                                                                                                   v-model="ListOfInsured[0].Gender"
                                                                                                   id="Gender2"
                                                                                                   value="84400002"
                                                                                                   data-val="84400002" v-validate="'required'">
                                                                                            <label class="form-radio-label radio-btn-style p-relative text-5 flex-grow-1"
                                                                                                   for="Gender2">
                                                                                                נקבה
                                                                                            </label>
                                                                                        </div>
                                                                                        <span class="invalid-feedback d-block mt-2">{{ errors.first('form1.ListOfInsured[0].Gender') }}</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <div class="s-input-wrapper mb-3">
                                                                                        <label class="text-5 color-6"><?php _e( 'Birthday', 'sogoc' ); ?></label>
                                                                                        <div class="form-group date-picker mb-0  ">
                                                                                            <input type="text"
                                                                                                   readonly="readonly"
                                                                                                   data-start="<?php echo $start_birthday; ?>"
                                                                                                   class="w-100 medium birthday-datepicker-1"
                                                                                                   v-model="ListOfInsured[0].BirthDate"
                                                                                                   name="ListOfInsured[0].BirthDate"
                                                                                                   readonly
                                                                                                   v-validate="'required'"
                                                                                            />
                                                                                        </div>
                                                                                        <span class="invalid-feedback d-block mt-2">{{ errors.first('ListOfInsured[0].BirthDate') }}</span>
                                                                                    </div>
                                                                                </div>
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
                                                                                                   id="smoking1"
                                                                                                   value="true"
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
                                                                                                   id="smoking2"
                                                                                                   value="false"
                                                                                                   data-val="IsSmoking" v-validate="'required'">
                                                                                            <label class="form-radio-label radio-btn-style p-relative text-5 flex-grow-1"
                                                                                                   for="smoking2">
                                                                                                לא
                                                                                            </label>
                                                                                        </div>
                                                                                        <span class="invalid-feedback d-block mt-2">{{ errors.first('form1.ListOfInsured[0].IsSmoking') }}</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>


                                                                        </div>
                                                                        <div class="person2 p-2 bg-8 border-top border-color-7"
                                                                             v-if="NumberOfInsured === '84200002'">
                                                                            <!-- First person-->
                                                                            <h2 class="text-5 color-4 pb-1 border-bottom border-color-5">מבוטח
                                                                                שני</h2>
                                                                            <div class="row">
                                                                                <div class="col-md-6 mb-3">
                                                                                    <div class="s-radio-wrapper">
                                                                                        <label class="text-5 color-6 d-inline-block mb-1">מין
                                                                                            המבוטח</label>
                                                                                        <div class="d-flex">
                                                                                            <input type="radio"
                                                                                                   class="form-radio-input opacity-0 p-absolute"
                                                                                                   name="ListOfInsured[1].Gender"
                                                                                                   v-model="ListOfInsured[1].Gender"
                                                                                                   id="Gender11"
                                                                                                   value="84400001"
                                                                                                   data-val="84400001" v-validate="'required'">
                                                                                            <label class="form-radio-label radio-btn-style p-relative text-5 flex-grow-1"
                                                                                                   for="Gender11">
                                                                                                זכר
                                                                                            </label>
                                                                                            &nbsp;
                                                                                            <input type="radio"
                                                                                                   class="form-radio-input opacity-0 p-absolute"
                                                                                                   name="ListOfInsured[1].Gender"
                                                                                                   v-model="ListOfInsured[1].Gender"
                                                                                                   id="Gender22"
                                                                                                   value="84400002"
                                                                                                   data-val="84400002" v-validate="'required'">
                                                                                            <label class="form-radio-label radio-btn-style p-relative text-5 flex-grow-1"
                                                                                                   for="Gender22">
                                                                                                נקבה
                                                                                            </label>
                                                                                        </div>
                                                                                        <span class="invalid-feedback d-block mt-2">{{ errors.first('form1.ListOfInsured[1].Gender') }}</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <div class="s-input-wrapper mb-3">
                                                                                        <label class="text-5 color-6"><?php _e( 'Birthday', 'sogoc' ); ?></label>
                                                                                        <div class="form-group date-picker mb-0  ">
                                                                                            <input type="text"
                                                                                                   readonly="readonly"
                                                                                                   data-start="<?php echo $start_birthday; ?>"
                                                                                                   class="w-100 medium birthday-datepicker-2"
                                                                                                   v-model="ListOfInsured[1].BirthDate"
                                                                                                   name="ListOfInsured[1].BirthDate"
                                                                                                   readonly
                                                                                                   v-validate="'required'"
                                                                                            />
                                                                                        </div>
                                                                                        <span class="invalid-feedback d-block mt-2">{{ errors.first('ListOfInsured[1].BirthDate') }}</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="row">
                                                                                <div class="col-md-6 mb-3">
                                                                                    <div class="s-radio-wrapper">
                                                                                        <label class="text-5 color-6 d-inline-block mb-1">
                                                                                            האם מעשן?</label>
                                                                                        <div class="d-flex">
                                                                                            <input type="radio"
                                                                                                   class="form-radio-input opacity-0 p-absolute"
                                                                                                   name="ListOfInsured[1].IsSmoking"
                                                                                                   v-model="ListOfInsured[1].IsSmoking"
                                                                                                   id="smoking11"
                                                                                                   value="true"
                                                                                                   data-val="IsSmoking" v-validate="'required'">
                                                                                            <label class="form-radio-label radio-btn-style p-relative text-5 flex-grow-1"
                                                                                                   for="smoking11">
                                                                                                כן
                                                                                            </label>
                                                                                            &nbsp;
                                                                                            <input type="radio"
                                                                                                   class="form-radio-input opacity-0 p-absolute"
                                                                                                   name="ListOfInsured[1].IsSmoking"
                                                                                                   v-model="ListOfInsured[1].IsSmoking"
                                                                                                   id="smoking22"
                                                                                                   value="false"
                                                                                                   data-val="IsSmoking" v-validate="'required'">
                                                                                            <label class="form-radio-label radio-btn-style p-relative text-5 flex-grow-1"
                                                                                                   for="smoking22">
                                                                                                לא
                                                                                            </label>
                                                                                        </div>
                                                                                        <span class="invalid-feedback d-block mt-2">{{ errors.first('form1.ListOfInsured[1].IsSmoking') }}</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>


                                                                        </div>
                                                                        <h2 class="text-3 color-4 pb-1">מסלולי משכנתא</h2>
                                                                        <b-form-group
                                                                                label="מספר מסלולים"
                                                                                :invalid-feedback="errors.first('form1.NumTracks')"
                                                                                :state="!errors.has('form1.NumTracks')">
                                                                            <b-form-select v-model="NumTracks"
                                                                                           name="NumTracks"
                                                                                           v-validate="'required'"
                                                                                           :options="[1,2,3,4,5]">
                                                                        </b-form-group>
                                                                        <div class="person2 person2 p-2 bg-8 border-top border-color-7"
                                                                             v-for="(track  ,index) in NumTracks">
                                                                            <!-- Second person-->
                                                                            <h2 class="text-5 color-4 pb-1">מסלול
                                                                                {{track}} </h2>
                                                                            <b-form-group label="סכום ביטוח מבוקש"
                                                                                          :invalid-feedback="errors.first('form1.ListOfTracks[' + index + '].DesiredSum')"
                                                                                          :state="!errors.has('form1.ListOfTracks[' + index + '].DesiredSum')"
                                                                            >
                                                                                <b-form-input type="number"
                                                                                              v-model="ListOfTracks[index].DesiredSum"
                                                                                              :name="'ListOfTracks[' + index + '].DesiredSum'"
                                                                                              v-validate="'required|between:1,3000000'"
                                                                                >
                                                                            </b-form-group>


                                                                            <b-form-group
                                                                                    label="תקופת ביטוח מבוקשת בשנים"
                                                                                    :invalid-feedback="errors.first('form1.ListOfTracks[' + index + '].DesiredPeriod')"
                                                                                    :state="!errors.has('form1.ListOfTracks[' + index + '].DesiredPeriod')">
                                                                                <b-form-input type="number"
                                                                                              v-validate="'required|between:1,35'"
                                                                                              v-model="ListOfTracks[index].DesiredPeriod"
                                                                                              :name="'ListOfTracks[' + index + '].DesiredPeriod'"
                                                                                >
                                                                            </b-form-group>
                                                                            <b-form-group
                                                                                    label="סוג הריבית במסלול">
                                                                                <b-form-select
                                                                                        v-model="ListOfTracks[index].InterestType"
                                                                                        name="ListOfTracks[index].InterestType"
                                                                                        :options="params.InterestType">

                                                                            </b-form-group>
                                                                            <b-form-group
                                                                                    label="שיעור הריבית במסלול"
                                                                                    :invalid-feedback="errors.first('form1.ListOfTracks[' + index + '].InterestRate')"
                                                                                    :state="!errors.has('form1.ListOfTracks[' + index + '].InterestRate')">
                                                                                <b-form-input type="number"
                                                                                              v-validate="'required|between:0,20'"
                                                                                              :name="'ListOfTracks[' + index + '].InterestRate'"
                                                                                              v-model="ListOfTracks[index].InterestRate"
                                                                                >
                                                                            </b-form-group>
                                                                        </div>
                                                                    </div>

                                                                    <div class="insOption1" v-if="insType !=='2'">
                                                                        <b-form-group
                                                                                :invalid-feedback="errors.first('form1.mtype')"
                                                                                :state="!errors.has('form1.mtype')"
                                                                                label="סוג מבנה וקומה">
                                                                            <b-form-select v-model="mtype"
                                                                                           v-validate="'required'"
                                                                                           name="mtype"
                                                                                           :options="params.mtype">
                                                                            </b-form-select>
                                                                        </b-form-group>
                                                                        <!-- house age-->
                                                                        <b-form-group
                                                                                :invalid-feedback="errors.first('form1.mage_parameter')"
                                                                                :state="!errors.has('form1.mage_parameter')"
                                                                                label="גיל המבנה בשנים">
                                                                            <b-form-input type="number"
                                                                                          v-model="mage_parameter"
                                                                                          v-validate="'required|between:0,99'"
                                                                                          name="mage_parameter" />
                                                                        </b-form-group>
                                                                        <div class="row">
                                                                            <div class="col-md-6 mb-3">
                                                                                <div class="s-radio-wrapper">
                                                                                    <label class="text-5 color-6 d-inline-block mb-1">
                                                                                        האם ידוע לך סכום ביטוח המבנה?
                                                                                    </label>
                                                                                    <div class="d-flex">
                                                                                        <input type="radio"
                                                                                               class="form-radio-input opacity-0 p-absolute"
                                                                                               name="KnowInsAmout"
                                                                                               v-model="KnowInsAmout"
                                                                                               id="KnowInsAmout1"
                                                                                               value="1"
                                                                                               data-val="1" v-validate="'required'">
                                                                                        <label class="form-radio-label radio-btn-style p-relative text-5 flex-grow-1"
                                                                                               for="KnowInsAmout1">
                                                                                            כן
                                                                                        </label>
                                                                                        &nbsp;
                                                                                        <input type="radio"
                                                                                               class="form-radio-input opacity-0 p-absolute"
                                                                                               name="KnowInsAmout"
                                                                                               v-model="KnowInsAmout"
                                                                                               id="KnowInsAmout2"
                                                                                               value="2"
                                                                                               data-val="2" v-validate="'required'">
                                                                                        <label class="form-radio-label radio-btn-style p-relative text-5 flex-grow-1"
                                                                                               for="KnowInsAmout2">
                                                                                            לא
                                                                                        </label>
                                                                                    </div>
                                                                                    <span class="invalid-feedback d-block mt-2">{{ errors.first('form1.KnowInsAmout') }}</span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <!-- house insurance total-->
                                                                        <b-form-group
                                                                                v-if="KnowInsAmout ==='1'"
                                                                                :invalid-feedback="errors.first('form1.msum')"
                                                                                :state="!errors.has('msum')"
                                                                                label='סכום ביטוח המבנה בש"ח'>
                                                                            <b-form-input type="number" v-model="msum"
                                                                                            name="msum"
                                                                                          v-validate="'required|between:100000,10000000'"/>
                                                                        </b-form-group>
                                                                        <b-form-group
                                                                                v-if="KnowInsAmout ==='2'"
                                                                                :invalid-feedback="errors.first('form1.house_sm')"
                                                                                :state="!errors.has('form1.house_sm')"
                                                                                label='מה שטח המבנה ברוטו (מ"ר)?'>
                                                                            <b-form-input type="number"
                                                                                          v-model="house_sm"
                                                                                          v-validate="'required|between:20,1000'"
                                                                                          name="house_sm"/>
                                                                        </b-form-group>
                                                                        <!-- house type -->
                                                                        <b-form-group

                                                                                :invalid-feedback="errors.first('form1.maim')"
                                                                                :state="!errors.has('form1.maim')"
                                                                                label="כיסוי לנזקי מים">
                                                                            <b-form-select
                                                                                    v-model="maim"
                                                                                    name="maim"
                                                                                           :options="params.maim" v-validate="'required'">

                                                                            </b-form-select>
                                                                        </b-form-group>
                                                                        <!-- suites type -->
                                                                        <b-form-group

                                                                                :invalid-feedback="errors.first('form1.mtvia')"
                                                                                :state="!errors.has('form1.mtvia')"
                                                                                label="האם הוגשו תביעות בשנים האחרונות בביטוח מבנה? (למעט בגין כיסוי לנזקי מים)">
                                                                            <b-form-select
                                                                                    v-model="mtvia"
                                                                                    name="mtvia"
                                                                                           :options="params.mtvia" v-validate="'required'">

                                                                            </b-form-select>
                                                                        </b-form-group>

                                                                    </div>

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
                                                        <div class="col-lg-12   px-lg-2">
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
                                                                           <div class="text-5 color-4 mb-1">מלא פרטי קשר ונחזור אליך עם הצעות מעולות</div>			                                                                                <?php echo do_shortcode('[contact-form-7 id="1110" title="טופס ביטוח משכנתא"]');?>
                                                                                    </div>
                                                                                    <div v-for="(item, key ) in list"
                                                                                         class="border-bottom border-color-3 col-12 mb-3">
                                                                                        <!-- FOREACH -->
                                                                                        <div class="insurance-cube pt-1 px-0">
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
                                                                                                    <div class="col-12  border-color-3">
                                                                                                        <!-- TITLE -->
                                                                                                        <div class="text-6 color-6 d-inline-block v-align-top"
                                                                                                             v-html="item.sub_title">
                                                                                                            >

                                                                                                        </div>
                                                                                                        <div v-if="item.Price">
                                                                                                            <span class="text-6 color-6">פרמיה חודשית ביטוח מבנה</span>
                                                                                                            <span class="text-3 color-3 medium ">
                                                                                                      {{ formatPrice(item.Price / 12) }} &#8362;
                                                                                                </span>
                                                                                                        </div>
                                                                                                        <div v-if="item.PriceLife">
                                                                                                            <span class="text-6 color-6">פרמיה חודשית ביטוח חיים</span>
                                                                                                            <span class="text-3 color-3 medium ">
                                                                                                      {{ formatPrice(item.PriceLife) }} &#8362;
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
                                                                                                  <!-- <div class="d-inline-block cursor-pointer ml-lg-3 receive-offer-by-email mb-1 mb-lg-0"
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
                                                                                                        <span class="text-custom-1 v-align-middle regular">דברו איתנו</span>
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
                                                                                                    <div style="border-bottom: 1px solid #c0c0c0" class="col-md-3 my-1 py-1 color-3">
                                                                                                        {{remark.RemarkTitle }}
                                                                                                    </div>
                                                                                                    <div style="border-bottom: 1px solid #c0c0c0" class="col-md-8 my-1 py-1 color-6">
                                                                                                        {{remark.RemarkBody}}
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="row text-6 px-2"
                                                                                                     >

                                                                                                    <div class="row pb-2">
                                                                                                        <div class="col-md-12"
                                                                                                             v-html="item.sub_title">
                                                                                                        </div>
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
                                    <div class="card" v-show="activeTab==3" :class="isActiveTab(3)">
                                        <div class="card-header p-0 bg-3 color-white" role="tab" id="headingOne">
                                            <h5 class="mb-0 text-5">
                                                <a data-toggle="" data-target="#collapse3"
                                                   class="d-flex align-items-center p-card"
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
                <!-- ROW SIDEBAR -->
                <div class="row hidden-md-down mb-3">
                    <div class="col-lg-12 text-center">
                        <span><?php dynamic_sidebar( $bottom_sidebar ) ?></span>
                    </div>
                </div>
                <!-- row -->
                <div class="row justify-content-center">
                    <div class="col-lg-4">
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
                maskantaType: '84200002',
                params: {},
                insType: null,
                selectedCompany: '',
                fullname: '',
                email: '',
                phone: '',
                tac: null,
                loader: false,
                KnowInsAmout: null,
                mashkanta: 1,
                ListOfInsured: {
                    0: {
                        'Gender': null,
                        'BirthDate': '',
                        'IsSmoking': '',
                        'ID': '1',
                        'Age': '',
                    },
                    1: {
                        'Gender': null,
                        'BirthDate': '',
                        'IsSmoking': '',
                        'ID': '2',
                        'Age': '',
                    },
                },
                NumTracks: null,
                ListOfTracks: {
                    0: {
                        DesiredPeriod: null,
                        DesiredSum: null,
                        ID: 1,
                        InterestRate: null,
                        InterestType: 84700002
                    },
                    1: {
                        DesiredPeriod: null,
                        DesiredSum: null,
                        ID: 1,
                        InterestRate: null,
                        InterestType: 84700002
                    },
                    2: {
                        DesiredPeriod: null,
                        DesiredSum: null,
                        ID: 1,
                        InterestRate: null,
                        InterestType: 84700002
                    },
                    3: {
                        DesiredPeriod: 0,
                        DesiredSum: 0,
                        ID: 1,
                        InterestRate: 0,
                        InterestType: 84700002
                    },
                    4: {
                        DesiredPeriod: 0,
                        DesiredSum: 0,
                        ID: 1,
                        InterestRate: 0,
                        InterestType: 84700002
                    },
                },
                CalculationType: 84300003,
                NumberOfInsured: null, // house type
                msum: null,
                house_sm: null,
                maim: null,
                mtype: null,
                tsum:null,
                mtype_parameter:null,
                ttype: null,
                mtvia: null,
                mage_parameter: null,
                ttype_parameter: null,
                ttvia: null
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
                            return 'יש להזין ערך בין '+ args[0] + ' ל-'+ args[1]
                        },
                        min: function (field) {
                            return 'נא להזין מספר נייד תקין';
                        },
                    },


                }),

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
                        'class': 'life',
                    },
                    success: function (response) {
                        self.params = response.data;
                    }
                });
                var startyear = (new Date).getFullYear() - 60
                var endtyear = (new Date).getFullYear() - 18
                //jQuery('.birthday-datepicker-1').live('focus', function () {
                    jQuery('.birthday-datepicker-1').datepicker({
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
                //jQuery('.birthday-datepicker-2').live('focus', function () {
                    jQuery('.birthday-datepicker-2').datepicker({
                        changeMonth: true,
                        changeYear: true,
                        yearRange: "-60:-18",
                        defaultDate: '-60y',
                        //    yearRange:  startyear + ":" + endtyear,
                        onSelect: function (dateText) {
                            self.ListOfInsured[1].BirthDate = dateText;
                        }
                    });
                //});
            },
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
                formatPrice(value) {
                    var val = (value / 1).toFixed(0);
                    return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                },
                onStep1() {
                    if( app.house_sm === 0){
                        app.house_sm =  app.msum * 6000;
                    }
                    this.$validator.validateAll("form1").then(function (result) {
                        if (result) { // valid form
                            app.loader = true;
                            app.activeTab = 2;
                            app.list = {};

                            jQuery.ajax({
                                type: "POST",
                                dataType: "json",
                                url: sogo.ajaxurl,
                                data: {
                                    'action': 'sogo_get_morgage',
                                    'order_data': JSON.stringify(app.$data),
                                    'morgage' : true
                                    //'d': 1
                                },
                                success: function (response) {
                                    app.list = response.data;
                                    app.activeTab = 2;
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
                },
                onStep2(key) {
                    app.selectedCompany = JSON.stringify(app.list[key]);
                    app.activeTab = 3;
                    jQuery("html, body").stop().animate({scrollTop: 0}, 500, 'swing', function () {
                    });
                },
                onSubmit() {
                    this.$validator.validateAll().then(function (result) {
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
    });


</script>
<?php get_footer(); ?>
