<template>
    <div class="block">
        <el-form  v-loading="loading"
                  element-loading-text="Loading..."
                  element-loading-spinner="el-icon-loading"
                  element-loading-background="rgba(0, 0, 0, 0.8)"
                  ref="form" :model="form" class="form-horizontal form-bordered">
            <el-tabs v-model="activeTabName">
                    <template v-for="locale in locales">
                        <el-tab-pane  class="" :label="lang[locale]" :name="locale">
                            <el-row>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">{{ lang.name }} {{ locale }}<span class="text-danger">*</span>:</label>
                                    <div class="col-md-6">
                                        <el-input class="el-input--is-round" maxlength="150" show-word-limit :disabled="loading"
                                                  v-model="form[locale].name"></el-input>
                                    </div>
                                </div>
                                <div class="form-group">

                                    <label class="col-md-2 control-label">{{ lang.text }} {{ locale }}<span class="text-danger">*</span>:</label>
                                    <div class="col-md-6">
                                        <ckeditor :config="editorConfig" :editor="editor" v-model="form[locale].text"></ckeditor>
                                    </div>

                                </div>

                                <div class="form-group" v-if="locale == default_locale">

                                    <label class="col-md-2 control-label">{{ lang.status }} {{ locale }}<span class="text-danger">*</span>:</label>
                                    <div class="col-md-6">
                                        <el-radio v-model="form.status" :label="1">{{ lang.status_yes }}</el-radio>
                                        <el-radio v-model="form.status" :label="0">{{ lang.status_no }}</el-radio>
                                    </div>

                                </div>
                            </el-row>

                        </el-tab-pane>

                    </template>

            </el-tabs>

            <div class="el-form-item registration-btn">
                <el-button type="primary" @click="save" :disabled="loading" style="margin: 0 1rem">{{ lang.save_text }}</el-button>
            </div>
        </el-form>
    </div>
</template>

<style>
    .el-transfer-panel{
        width: 387px;
    }
</style>
<script>
    import {responseParse} from '../../mixins/responseParse'
    import {getData} from '../../mixins/getData'
    import {hasPermission} from '../../mixins/hasPermission'
    import {Notification} from 'element-ui'
    import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
    import MyUploadAdapter from '../../mixins/EditorCustomUpload';

    export default {
        props: [
            'getSaveDataRoute',
            'id',
            'editor_config'
        ],

        data(){
            return {
                item: {},
                data: [],
                loading: false,
                lang: {},
                routes: {},
                options: {},

                /**
                 * Form data
                 */
                form: {
                    ka: {},
                    en: {},
                    id: this.id
                },

                activeTabName: '',
                locales: [],
                editor: ClassicEditor,
                editorConfig: this.editor_config
            }
        },
        created(){
            // Set upload plugin.
            this.editorConfig.extraPlugins = [ this.meyCustomUploadAdapterPlugin ];
            this.getSaveData();
        },

        methods: {

            /**
             * Upload custom image in editor.
             */
            meyCustomUploadAdapterPlugin(editor){

                editor.plugins.get( 'FileRepository' ).createUploadAdapter = ( loader ) => {
                    // Configure the URL to the upload script in your back-end here!
                    return new MyUploadAdapter( loader);
                };

            },

            modifyCreateData(){

                // Set default locale.
                this.activeTabName = this.default_locale;

                this.locales.forEach((locale) => {

                    let trans_values= {};
                    if (this.item) {
                        trans_values = this.getTranslationValues(this.item.translations, locale);
                    }

                    this.form[locale] = {
                        name: trans_values ? trans_values.name : ''
                    };

                });

            },

            getTranslationValues(translations, locale){

                let values = {};

                if (!translations) {
                    return values;
                }

                Object.keys(translations).forEach((key) => {

                    if (translations[key].locale == locale) {
                        values = translations[key];
                    }

                });

                return values;
            },

            /**
             *
             * Get save data.
             *
             * @returns {Promise<void>}
             */
            async getSaveData(){

                this.loading = true;

                await getData({
                    method: 'POST',
                    url: this.getSaveDataRoute,
                    data: this.form
                }).then(response => {

                    // Parse response notification.
                    responseParse(response, false);

                    if (response.code == 200) {

                        // Response data.
                        let data = response.data;

                        this.lang = data.trans_text;
                        this.routes = data.routes;
                        this.options = data.options;
                        this.default_locale = data.default_locale;
                        this.locales = data.locales;
                        this.item = data.item ? data.item : {};

                        // Modify create data.
                        this.modifyCreateData();

                    }

                    this.loading = false


                })

            },

            async save(){

                this.loading = true;

                this.$confirm(this.lang.confirm_save, {
                    confirmButtonText: this.lang.confirm_save_yes,
                    cancelButtonText: this.lang.confirm_save_no,
                    type: 'warning'
                })
                    .then(async () => {

                        await getData({
                            method: 'POST',
                            url: this.routes.save,
                            data: this.form
                        }).then(response => {

                            // Parse response notification.
                            responseParse(response);

                            if (response.code == 200) {

                                // Response data.
                                let data = response.data;

                                window.location.reload();

                            }

                            this.loading = false


                        })

                    }).catch(() => {
                    this.loading = false;
                });
            },

        }

    }
</script>
