<template>
    <div>
        <el-drawer
            v-loading="loading"
            element-loading-text="Loading..."
            element-loading-spinner="el-icon-loading"
            element-loading-background="rgba(0, 0, 0, 0)"
            :title="lang.add_image"
            :visible.sync="dialogVisible"
            size="60%"
            direction="rtl"
            custom-class="demo-drawer"
            ref="drawer"
            :before-close="handleClose">
            <div class="demo-drawer__content">


                <el-tabs v-model="def_locale" v-if="item_field">
                    <template v-for="(locale,localeKey) in locales">

                        <el-tab-pane class="" :label="locale" :name="locale">
                            <template v-for="(field,index) in item_field.inputs">
                                <div :class="field.class && field.class.form_group ? field.class.form_group : formData.fields.class.form_group_class" v-if="field.is_translations || (!field.is_translations && localeKey == 0)">
                                    <label :class="field.class && field.class.label ? field.class.label : formData.fields.class.label_class">{{ field.label }} {{ field.is_translations ? locale : '' }}
                                        <template v-if="field.is_required">
                                            <span class="text-danger">*</span>:
                                        </template>
                                    </label>
                                    <div :class="field.class && field.class.input_div ? field.class.input_div : formData.fields.class.input_div_class">

                                        <template v-if="field.type == 'text'">
                                            <template v-if="field.is_translations">
                                                <el-input
                                                    class="el-input--is-round"
                                                    :disabled="loading"
                                                    :placeholder="field.placeholder ? field.placeholder : ''"
                                                    v-model="image_form[locale][field.name]"></el-input>
                                            </template>
                                            <template v-else>
                                                <el-input
                                                    class="el-input--is-round"
                                                    :disabled="loading"
                                                    :placeholder="field.placeholder ? field.placeholder : ''"
                                                    v-model="image_form[field.name]"></el-input>
                                            </template>
                                        </template>
                                        <template v-else-if="field.type == 'textarea'">
                                            <template v-if="field.is_translations">
                                                <el-input type="textarea" class="el-input--is-round" :disabled="loading" :placeholder="field.placeholder ? field.placeholder : ''"
                                                          v-model="image_form[locale][field.name]"></el-input>
                                            </template>
                                            <template v-else>
                                                <el-input type="textarea" class="el-input--is-round" :disabled="loading" :placeholder="field.placeholder ? field.placeholder : ''"
                                                          v-model="image_form[field.name]"></el-input>
                                            </template>
                                        </template>
                                    </div>

                                </div>
                            </template>
                        </el-tab-pane>

                        <div class="form-group" v-if="localeKey == 0">

                            <label class="col-md-2 control-label">{{ lang.image_url }}<span
                                class="text-danger">*</span>:</label>
                            <div class="col-md-6">
                                <input style="display: block !important;" id="file" ref="file" type="file"
                                       v-on:change="handleFileUpload()"/>
                            </div>

                            <div v-if="image_form.url">
                                <div class="col-md-offset-2 col-md-6 padding-t">
                                    <img :src="image_form.url" style="width: 100%;">
                                </div>
                            </div>
                        </div>

                    </template>
                </el-tabs>
                <div class="form-group">
                    <div class="col-md-12">
                        <div class="demo-drawer__footer">
                            <el-button size="medium" type="info is-plain" @click="modal(false)">{{ lang.cancel_image
                                }}
                            </el-button>
                            <el-button size="medium" type="primary is-plain" icon="el-icon-check" @click="saveimage"
                                       :disabled="loading" :loading="loading">{{ lang.save_image }}
                            </el-button>
                        </div>
                    </div>
                </div>
            </div>
        </el-drawer>
    </div>
</template>

<script>
    import {responseParse} from '../../mixins/responseParse'
    import {getData} from '../../mixins/getData'

    export default {
        props: [
            'item_field',
            'lang',
            'upload_image_route',
            'locales',
            'default_locale',
            'tab_name',
            'edit_data',
            'options',
            'updateImageData',
            'formData'
        ],
        data() {
            return {
                activeTabName: 'ka',
                dialogVisible: false,
                loading: false,
                image_form: {
                    ka: {},
                    en: {},
                    url: ''
                },
                def_locale: this.default_locale
            }
        },
        created() {
            this.dialogVisible = true;
            this.image_form = this.edit_data;
            console.log(this.edit_data,'dsadas');
        },
        methods: {

            /**
             * File upload.
             */
            async handleFileUpload() {

                let file = this.$refs.file[0].files[0];

                this.image_form = {...this.image_form, ...{url: URL.createObjectURL(file)}};

                var data = new FormData();
                data.append('file', file);
                data.append('type', 'gallery_image');

                await getData({
                    method: 'POST',
                    url: this.upload_image_route,
                    data: data
                }).then(response => {
                    // Parse response notification.
                    responseParse(response);
                    if (response.code == 200) {
                        // Response data.
                        let data = response.data;
                        // Set image.
                        this.image_form.image_id = data.file.id;
                    }
                    this.loading = false
                });

            },

            clearInputs() {
                this.locales.forEach((locale) => {
                    this.image_form[locale] = {}
                });
                this.image_form = {...this.image_form, ...{link: '', index: '', url: ''}};
            },

            /**
             * Modal close/show
             */
            modal(status = true) {

                if (status) {
                    this.clearInputs();
                } else {
                    this.updateImageData();
                }

                this.dialogVisible = status;
            },

            /**
             *
             * @param done
             */
            handleClose(done) {
                this.updateImageData();
                done();
            },

            /**
             * Save image data.
             */
            saveimage() {
                // return;
                let data = Object.assign({}, this.image_form);
                this.updateImageData(data, this.image_form ? this.image_form.index : '');
                this.modal(false);
            }

        }


    }

</script>
