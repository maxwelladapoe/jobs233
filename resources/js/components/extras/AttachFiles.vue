<template>

    <div>

        <label class=" t-mont t-bold mb-3">
            <b-icon icon="paperclip" type="is-primary" size="is-small"/>
            Attach
            Necessary Files(Optional)</label>


        <div class="jb-attached-files">
            <div class="dropzone" @dragover.prevent="dragover"
                 :class="dropAreaDragOver?'active':''"
                 @dragleave.prevent="dragleave" @drop.prevent="drop">
                <input type="file" multiple
                       name="fields[assetsFieldHandle][]"
                       id="assetsFieldHandle"
                       class="is-hidden"
                       @change="onFileInputChange" ref="file"
                       accept=".pdf,.jpg,.jpeg,.png"/>

                <label for="assetsFieldHandle"
                       class="text-center click-here has-text-centered">
                    <div>
                        <p class="t-meri m-0">Drag or drop files here or
                            <span
                                class="underline">click here</span></p>
                        <p class="t-meri m-0">to select</p>
                    </div>
                </label>

            </div>


            <div>
                <div class="mt-4 columns is-mobile is-multiline"
                     v-if="uploadedFileList.length">
                    <div class="column is-12-mobile is-6-desktop"
                         v-for="file in uploadedFileList">
                        <div class="box is-relative">

                            <div >

                                    <div class="">
                                        <figure class="image is-32x32">
                                            <template
                                                v-if="['xlsx','docx'].includes(file.name.split('.').pop().toLowerCase() )">
                                                <img
                                                    src="/images/file_type_icons/doc.svg"
                                                    alt="" width="35">
                                            </template>
                                            <template v-else>
                                                <img
                                                    :src="`/images/file_type_icons/${file.name.split('.').pop()}.svg`"
                                                    alt="" width="35">
                                            </template>
                                        </figure>
                                    </div>
                                    <div class="">
                                        <p class="t-bold t-6">{{ file.name }}</p>
                                        <p class=" t-6">{{ formatBytes(file.size)}}</p>
                                    </div>

                            </div>

                            <button class="jb-close-button delete" type="button" rounded size="is-small"
                                 @click="remove(uploadedFileList.indexOf(file))"
                                 title="Remove file">
                                <b-icon icon="close" size="is-small"/>
                            </button>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>

</template>

<script>
    export default {
        name: "AttachFiles",
        props: {
            value: {
                type: Array,
                required: true
            }
        },

        data() {
            return {
                uploadedFileList: [],
                dropAreaDragOver: false,
                dropAreaDragLeave: false,
            }
        },

        created() {
            this.uploadedFileList = this.value;
        },
        methods: {

            onFileInputChange() {
                this.uploadedFileList.push(...this.$refs.file.files);
                this.$emit('input', this.uploadedFileList);
            },

            drop(event) {
                this.$refs.file.files = event.dataTransfer.files;
                this.onFileInputChange();

                this.dropAreaDragOver = false;
                this.dropAreaDragLeave = false;
            },

            dragover(event) {
                this.dropAreaDragOver = true;
            },

            dragleave(event) {
                this.dropAreaDragOver = false;
                this.dropAreaDragLeave = true;
            },
            remove(i) {
                this.uploadedFileList.splice(i, 1);
            },
            formatBytes(a, b = 2) {
                if (0 === a) return "0 Bytes";
                const c = 0 > b ? 0 : b, d = Math.floor(Math.log(a) / Math.log(1024));
                return parseFloat((a / Math.pow(1024, d)).toFixed(c)) + " " + ["Bytes", "KB", "MB", "GB", "TB", "PB", "EB", "ZB", "YB"][d]
            },


        },
        watch (value) {
            // This causes, that v-model on parent will work!
            this.$emit('input', this.value)
        }
    }
</script>

<style scoped>

</style>
