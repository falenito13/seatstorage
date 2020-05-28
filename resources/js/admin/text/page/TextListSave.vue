<template>
    <div class="block">

        <el-form class="form-horizontal form-bordered"  v-loading="loading"
                 element-loading-text="Loading..."
                 element-loading-spinner="el-icon-loading"
                 element-loading-background="rgba(0, 0, 0, 0.8)"
                 @submit.native.prevent :model="form" label-width="200px">

            <el-tabs v-model="activeTabName">

                <template v-for="(lang_file,file_name) in lang_files">

                    <el-tab-pane  class="" :label="file_name" :name="file_name">

                        <div class="table-responsive">
                            <table class="table table-vcenter table-striped">
                                <thead>
                                <tr>
                                    <th width="15%">{{ trans_text.file_name }}</th>
                                    <th>{{ trans_text.key }}</th>
                                    <th v-for="loc in all_locales">{{ loc }}</th>
                                    <th width="30%" class="text-center">{{ trans_text.actions }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                <template v-for="(file_text, key) in lang_file">
                                    <tr>
                                        <td>{{ file_name }}</td>
                                        <td>{{ key }}</td>
                                        <template v-for="loc in all_locales">
                                            <td>
                                                <el-input placeholder="Please input" v-model="lang_files[file_name][key][loc]"></el-input>
                                            </td>
                                        </template>
                                        <td class="text-center">
                                            <el-button
                                                @click="updateText({file: file_name, key: key, text: file_text})"
                                                :title="trans_text.edit_title"
                                                size="small"
                                                type="success"
                                                icon="el-icon-check"
                                            ></el-button>
                                            <el-button
                                                :title="trans_text.delete_title"
                                                size="small"
                                                type="danger"
                                                icon="el-icon-delete">
                                            </el-button>
                                        </td>
                                    </tr>
                                </template>
                                </tbody>
                            </table>
                        </div>

                    </el-tab-pane>

                </template>

            </el-tabs>


        </el-form>

    </div>
</template>

<script>

    import {getData} from '../../../mixins/getData'
    import {responseParse} from '../../../mixins/responseParse'

    export default {

        props: [
            'indexDataRoute'
        ],
        data(){
            return {

                loading: false,
                form: {},

                activeTabName: 'auth',

                /**
                 * Lang file list.
                 */
                lang_files: [],

                // Trans title text.
                trans_text: {},

                // All locales list.
                all_locales: [],

                // Routes list.
                routes: {}

            }
        },
        created(){
          this.getIndexBaseData();
        },
        methods: {

            /**
             *
             * Save text.
             *
             */
            async updateText(form){

                this.loading = true;

                await getData({
                    method: 'POST',
                    url: this.routes.update,
                    data: form
                }).then(response => {

                    // Parse response notification.
                    responseParse(response);

                    if (response.code == 200) {
                        // this.getIndexBaseData();
                    }
                    
                    this.loading = false;

                })

            },

            /**
             *
             * @returns {Promise<void>}
             */
            async getIndexBaseData(){

                this.loading = true;

                await getData({
                    method: 'POST',
                    url: this.indexDataRoute,
                    data: this.form
                }).then(response => {

                    // Parse response notification.
                    responseParse(response, false);

                    if (response.code == 200) {

                        /**
                         * Response data.
                         *
                         * @type {T}
                         */
                        let data = response.data;

                        this.lang_files = data.lang_files;
                        this.trans_text = data.trans_text;
                        this.all_locales = data.locales;
                        this.routes = data.routes;

                        console.log(this.lang_files);

                    }

                    this.loading = false;


                })
            },

        }

    }

</script>
