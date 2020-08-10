<template>
    <div class="block">
        <el-form  v-loading="loading"
                  element-loading-text="Loading..."
                  element-loading-spinner="el-icon-loading"
                  element-loading-background="rgba(0, 0, 0, 0.0)"
                  ref="form" :model="form" class="form-horizontal form-bordered">
            <el-row>
                <el-tabs v-model="default_locale" v-if="form">
                    <template v-for="(locale,localeKey) in locales">

                        <el-tab-pane class="" :label="locale" :name="locale">

                            <template v-for="(field,index) in fields">

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
                                                    v-model="form[locale][field.name]"></el-input>
                                            </template>
                                            <template v-else>
                                                <el-input
                                                    class="el-input--is-round"
                                                    :disabled="loading"
                                                    :placeholder="field.placeholder ? field.placeholder : ''"
                                                    v-model="form[field.name]"></el-input>
                                            </template>
                                        </template>
                                        <template v-else-if="field.type == 'textarea'">
                                            <template v-if="field.is_translations">
                                                <el-input type="textarea" class="el-input--is-round" :disabled="loading" :placeholder="field.placeholder ? field.placeholder : ''"
                                                          v-model="form[locale][field.name]"></el-input>
                                            </template>
                                            <template v-else>
                                                <el-input type="textarea" class="el-input--is-round" :disabled="loading" :placeholder="field.placeholder ? field.placeholder : ''"
                                                          v-model="form[field.name]"></el-input>
                                            </template>
                                        </template>
                                        <template v-else-if="field.type == 'date'">
                                            <el-date-picker
                                                :disabled="loading"
                                                format="yyyy-MM-dd"
                                                value-format="yyyy-MM-dd"
                                                v-model="form[field.name]"
                                                type="date"
                                                :placeholder="field.placeholder ? field.placeholder : ''">
                                            </el-date-picker>
                                        </template>
                                        <template v-else-if="field.type == 'datetime'">
                                            <el-date-picker
                                                :disabled="loading"
                                                format="yyyy-MM-dd HH:mm:ss"
                                                value-format="yyyy-MM-dd HH:mm:ss"
                                                v-model="form[field.name]"
                                                type="datetime"
                                                :placeholder="field.placeholder ? field.placeholder : ''">
                                            </el-date-picker>
                                        </template>
                                        <template v-else-if="field.type == 'checkbox'">
                                            <el-checkbox v-model="form[field.name]">{{ field.placeholder }}</el-checkbox>
                                        </template>
                                        <template v-else-if="field.type == 'radio'">
                                            <el-radio
                                                :key="option.value"
                                                v-for="option in field.options"
                                                v-model="form[field.name]"
                                                :label="option.value">
                                                {{ option.label }}
                                            </el-radio>
                                        </template>
                                        <template v-else-if="field.type == 'wysiwyg'">
                                            <template v-if="field.is_translations">
                                                <ckeditor :config="editorConfig" :editor="editor"
                                                          v-model="form[locale][field.name]"></ckeditor>
                                            </template>
                                            <template v-else>
                                                <ckeditor :config="editorConfig" :editor="editor"
                                                          v-model="form[field.name]"></ckeditor>
                                            </template>

                                        </template>
                                        <template v-else-if="field.type == 'select'">
                                            <el-select v-model="form[field.name]" clearable filterable :placeholder="field.placeholder">
                                                <el-option
                                                    v-for="item in field.options"
                                                    :key="item.value"
                                                    :label="item.label"
                                                    :value="item.value">
                                                </el-option>
                                            </el-select>
                                        </template>
                                        <template v-else-if="field.type == 'select_multiple'">
                                            <el-select v-model="form[field.name]" clearable filterable multiple :placeholder="field.placeholder">
                                                <el-option
                                                    v-for="item in field.options"
                                                    :key="item.value"
                                                    :label="item.label"
                                                    :value="item.value">
                                                </el-option>
                                            </el-select>
                                        </template>
                                        <template v-else-if="field.type == 'input_number'">
                                            <template v-if="field.is_translations">
                                                <el-input-number
                                                    :precision="field.params.precision"
                                                    :step="field.params.step"
                                                    :min="field.params.min"
                                                    :max="field.params.max"
                                                    class="el-input--is-round"
                                                    :disabled="loading"
                                                    v-model="form[locale][field.name]"></el-input-number>
                                            </template>
                                            <template v-else>
                                                <el-input-number
                                                    :precision="field.params.precision"
                                                    :step="field.params.step"
                                                    :min="field.params.min"
                                                    :max="field.params.max"
                                                    class="el-input--is-round"
                                                    :disabled="loading"
                                                    v-model="form[field.name]"></el-input-number>
                                            </template>
                                        </template>
                                        <template v-else-if="field.type == 'multi_image'">
                                            <MultiImageUpload
                                                :formData="formData"
                                                :field="field"
                                                :updateData="updateData"
                                                :lang="lang"
                                                :upload_image_route="field.route"
                                                :locales="locales"
                                                :default_locale="default_locale"
                                                :module_name="field.name"
                                                :item="form[field.name]"
                                                :editor_config="editor_config">
                                            </MultiImageUpload>
                                        </template>
                                    </div>
                                </div>

                            </template>

                        </el-tab-pane>

                    </template>

                </el-tabs>

            </el-row>

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
    import {responseParse} from '../mixins/responseParse'
    import {getData} from '../mixins/getData'
    import MyUploadAdapter from '../mixins/EditorCustomUpload';
    import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
    import MultiImageUpload from "./MultiImageUpload";

    export default {
        components: {MultiImageUpload},
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
                form: {
                    id: this.id
                },
                editor: ClassicEditor,
                editorConfig: this.editor_config,
                fields: [],
                formData: {},
                values: {},
                default_locale: '',
                locales: []
            }
        },
        created(){
            this.getSaveData();
            this.editorConfig.extraPlugins = [this.meyCustomUploadAdapterPlugin];
        },

        methods: {
            /**
             *
             * @param module
             * @param data
             */
            updateData(module, data) {
                this.form[module] = data;
            },
            modifyCreateData(){
                this.form = this.values;
            },
            /**
             * Upload custom image in editor.
             */
            meyCustomUploadAdapterPlugin(editor) {

                editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
                    // Configure the URL to the upload script in your back-end here!
                    return new MyUploadAdapter(loader);
                };

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

                        this.lang               = data.trans_text;
                        this.routes             = data.routes;
                        this.options            = data.options;
                        this.default_locale     = data.default_locale;
                        this.locales            = data.locales;
                        this.item               = data.item ? data.item : {};
                        this.fields             = data.fields;
                        this.formData           = data.form;
                        this.values             = data.values;
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
