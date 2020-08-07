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

                <el-tabs v-model="activeTabName">

                    <template v-for="locale in locales">

                        <el-tab-pane :label="lang[locale]" :name="locale">

                            <el-row>
                                <el-col :span="24">

                                    <div class="form-group">

                                        <label class="col-md-2 control-label">{{ lang.image_title }} {{ locale }}<span
                                            class="text-danger">*</span>:</label>
                                        <div class="col-md-9">
                                            <el-input class="el-input--is-round"
                                                      v-model="image_form[locale].title"></el-input>
                                        </div>
                                    </div>
                                </el-col>

                                <el-col :span="24" v-if="locale == default_locale">

                                    <div class="form-group">

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

                                </el-col>

                            </el-row>

                        </el-tab-pane>

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
            'lang',
            'upload_image_route',
            'locales',
            'default_locale',
            'tab_name',
            'old_data',
            'options',
            'updateImageData'
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
                }
            }
        },
        created() {
            this.dialogVisible = true;
            // if (this.$store.getters.galleryEditData) {
            //     let data = this.$store.getters.galleryEditData;
                this.image_form = data;
            // }
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
                        this.image_form.image_id = data.image.id;
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
