<template>
    <div class="row check">
        <div class="col-lg-12">
            <b-card header="Toggle Buttons" header-tag="h4" class="bg-warning-card">
                <div class="row">
                    <div class="col-lg-6">
                        <h5>Colors</h5>
                        <toggle-button :value="false" :sync="true" :labels="true" :color="{checked: '#09BD8F', unchecked: '#dc6460'}" />
                        <h5 class="mt-3
">Lables</h5>
                        <toggle-button :value="true" :labels="{checked: 'Checked', unchecked: 'UnChecked'}" :width="100" :color="{checked: '#09BD8F', unchecked: '#dc6460'}" />
                        <h5 class="mt-3">Width</h5>
                        <toggle-button :value="true" :labels="true" :width="50" :color="{checked: '#09BD8F', unchecked: '#dc6460'}" />
                        <toggle-button :value="true" :labels="true" :width="60" :color="{checked: '#09BD8F', unchecked: '#dc6460'}" />
                        <toggle-button :value="true" :labels="true" :width="100" :color="{checked: '#09BD8F', unchecked: '#dc6460'}" />
                        <toggle-button :value="true" :labels="true" :width="120" :color="{checked: '#09BD8F', unchecked: '#dc6460'}" />
                    </div>
                    <div class="col-lg-6 ">
                        <h5 class="mb-3 mt-3">Basic</h5>
                        <toggle-button :value="false" :sync="true" :labels="true" :color="{checked: '#6f9dd6', unchecked: '#6f9dd6'}" class="mb-5 togglesiwtch" />
                        <h5 class="mb-3">Disabled</h5>
                        <div class="cur">
                            <toggle-button :value="false" :sync="true" :labels="true" :disabled="true" class="cur" />
                            <toggle-button :value="true" :sync="true" :labels="true" :disabled="true" class="cur" />
                        </div>
                    </div>
                </div>
            </b-card>
        </div>
        <div class="col-lg-6">
            <b-card header="Checkboxes with animations" header-tag="h4" class="bg-info-card">
                <div class="row">
                    <div class="col-lg-6">
                        <div>
                            <label>
                                <input class="checkbox-hey" type="checkbox"> Hey</label>
                        </div>
                        <div>
                            <label>
                                <input class="checkbox-away" type="checkbox"> Away</label>
                        </div>
                        <div>
                            <label>
                                <input class="checkbox-inout" type="checkbox"> Inout
                            </label>
                        </div>
                        <div>
                            <label>
                                <input class="checkbox-rotate" type="checkbox"> Rotate
                            </label>
                        </div>
                        <div>
                            <label>
                                <input class="checkbox-yo" type="checkbox"> Yo</label>
                        </div>
                        <div>
                            <label>
                                <input class="checkbox-roll" type="checkbox"> Roll</label>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div>
                            <label>
                                <input class="checkbox-up" type="checkbox"> Up</label>
                        </div>
                        <div>
                            <label>
                                <input class="checkbox-down" type="checkbox"> Down
                            </label>
                        </div>
                        <div>
                            <label>
                                <input class="checkbox-tv" type="checkbox"> Tv</label>
                        </div>
                        <div>
                            <label>
                                <input class="checkbox-jump" type="checkbox"> Jump</label>
                        </div>
                        <div>
                            <label>
                                <input class="checkbox-omg" type="checkbox"> Omg</label>
                        </div>
                        <div>
                            <label>
                                <input class="checkbox-splash" type="checkbox"> Splash</label>
                        </div>
                    </div>
                </div>
            </b-card>
        </div>
        <div class="col-lg-6">
            <b-card header="Radios with animations" header-tag="h4" class="bg-danger-card">
                <div class="row">
                    <div class="col-lg-6">
                        <div>
                            <label tabindex="0">
                                <input class="radiobox-tremolo" type="radio" name="x" value="1"> Tremolo
                            </label>
                        </div>
                        <div>
                            <label>
                                <input class="radiobox-boing" type="radio" name="x" value="2"> Boing
                            </label>
                        </div>
                        <div>
                            <label>
                                <input class="radiobox-boom" type="radio" name="x" value="3"> Boom
                            </label>
                        </div>
                        <div>
                            <label>
                                <input class="radiobox-flash" type="radio" name="x"> Flash
                            </label>
                        </div>
                        <div>
                            <label>
                                <input class="radiobox-wheel" type="radio" name="x"> Wheel
                            </label>
                        </div>
                        <div>
                            <label>
                                <input class="radiobox-return" type="radio" name="x"> Return
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div>
                            <label>
                                <input class="radiobox-scatman" type="radio" name="x"> Scatman
                            </label>
                        </div>
                        <div class=" ">
                            <label>
                                <input class="radiobox-vertigo" type="radio" name="x"> Vertigo
                            </label>
                        </div>
                        <div>
                            <label>
                                <input class="radiobox-pump" type="radio" name="x"> Pump</label>
                        </div>
                        <div>
                            <label>
                                <input class="radiobox-focus" type="radio" name="x"> Focus
                            </label>
                        </div>
                        <div>
                            <label>
                                <input class="radiobox-hooray" type="radio" name="x"> Hooray
                            </label>
                        </div>
                        <div>
                            <label>
                                <input class="radiobox-ufo" type="radio" name="x"> Ufo
                            </label>
                        </div>
                    </div>
                </div>
            </b-card>
        </div>
        <div class="col-lg-6">
            <b-card header="Check boxes" header-tag="h4" class="bg-success-card">
                <div class="row">
                    <div class="col-12 mb-2">
                        <h5>Color checkboxes</h5>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <b-form-checkbox class="primarycheck">Primary</b-form-checkbox>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <b-form-checkbox class="infocheck">Info</b-form-checkbox>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <b-form-checkbox class="warningcheck">Warning</b-form-checkbox>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <b-form-checkbox class="dangercheck">Danger</b-form-checkbox>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <b-form-checkbox class="successcheck">Success</b-form-checkbox>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <b-form-checkbox class="defaultcheck">Default</b-form-checkbox>
                    </div>
                </div>
                <div class="row ">
                    <div class="col-12 mt-3">
                        <h5>Inline checkboxes</h5>
                    </div>
                    <div class="col-12">
                        <b-form-checkbox-group
                                            :options="options"
                                            name="radioInline">
                        </b-form-checkbox-group>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-12">
                        <h5>Intermediate checkboxes</h5>
                    </div>
                    <div class="col-lg-4 col-md-6 mt-2">
                        <b-form-checkbox v-model="checked" :indeterminate.sync="indeterminate">
                            Intermediate
                        </b-form-checkbox>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <h5> Disabled  </h5>
                    </div>
                    <div class="col-lg-4 col-md-6 mt-2">
                        <b-form-checkbox :disabled=true>Can't check
                        </b-form-checkbox>
                    </div>
                    <div class="col-lg-4 col-md-6 mt-2">
                        <b-form-checkbox :disabled=true>This too
                        </b-form-checkbox>
                    </div>
                    <div class="col-lg-4 col-md-6 mt-2">
                        <b-form-checkbox :disabled=true>And this
                        </b-form-checkbox>
                    </div>
                </div>
            </b-card>
        </div>
        <div class="col-lg-6 ">
            <b-card header="Radios" header-tag="h4" class="bg-info-card">
                <div class="row">
                    <div class="col-12 mb-2">
                        <h5>Color Radios</h5>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="custom-controls-stacked">
                            <b-form-radio checked="false" class="primaryradio">Primary
                            </b-form-radio>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <b-form-radio checked="false" class="inforadio">Info
                        </b-form-radio>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <b-form-radio checked="false" class="warningradio">Warning
                        </b-form-radio>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <b-form-radio checked="false" class="dangerradio">Danger
                        </b-form-radio>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <b-form-radio checked="false" class="successradio">Success
                        </b-form-radio>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-3">
                        <b-form-radio checked="false" class="defaultradio">Default
                        </b-form-radio>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <h5>Inline radios</h5>
                    </div>
                    <div class="col-lg-12 mt-2">
                        <div class="custom-controls-stacked">
                            <b-form-radio-group :options="radiooptions">
                            </b-form-radio-group>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-12">
                        <h5> Disabled state</h5>
                    </div>
                    <div class="col-lg-6 mt-3">
                        <b-form-radio :disabled=true checked="false">Its Disbaled</b-form-radio>
                    </div>
                    <div class="col-lg-6 mt-3">
                        <b-form-radio :disabled=true checked="false">Can't check</b-form-radio>
                    </div>
                </div>
            </b-card>
        </div>
    </div>
</template>
<script>
require("checkbox.css/dist/css/checkbox.min.css");
require("radiobox.css/dist/css/radiobox.min.css");
export default {
    name: "radios_checkboxes",
    data(){
        return{
            options: [
                { text: 'First Checkbox', value: 'first' },
                { text: 'Second Checkbox', value: 'second' },
                { text: 'Third Checkbox', value: 'third' }
            ],
            checked: true,
            indeterminate: true,
            radiooptions: [
                { text: 'First radio', value: 'first' },
                { text: 'Second radio', value: 'second' },
                { text: 'Third radio', value: 'third' }
            ],
        }
    },
    methods: {
        changeState() {
            var el = document.getElementById("indeterminateCheckbox");
            if (el.readOnly) el.checked = el.readOnly = false;
            else if (!el.checked) el.readOnly = el.indeterminate = true;
        }
    }
}
</script>
<style >
.wrapper .primarycheck .custom-control-input:checked ~  .custom-control-label::before,
.wrapper .primaryradio .custom-control-input:checked ~  .custom-control-label::before{
    background-color: #428bca !important;
}
.wrapper .infocheck .custom-control-input:checked ~  .custom-control-label::before,
.wrapper .inforadio .custom-control-input:checked ~  .custom-control-label::before{
    background-color: #4fc1e9 !important;
}

.wrapper .warningcheck .custom-control-input:checked ~  .custom-control-label::before,
.wrapper .warningradio .custom-control-input:checked ~  .custom-control-label::before{
    background-color: #ffb65f !important;
}

.wrapper .dangercheck .custom-control-input:checked ~  .custom-control-label::before,
.wrapper .dangerradio .custom-control-input:checked ~  .custom-control-label::before{
    background-color: #fb8678 !important;
}

.wrapper .successcheck .custom-control-input:checked ~  .custom-control-label::before,
.wrapper .successradio .custom-control-input:checked ~  .custom-control-label::before{
    background-color: #22d69d !important;
}

.wrapper .defaultcheck .custom-control-input:checked ~  .custom-control-label::before,
.wrapper .defaultradio .custom-control-input:checked ~  .custom-control-label::before {
    background-color: #CCC !important;
}

input {
    cursor: pointer;
}

.cur {
    cursor: not-allowed;
}
</style>
