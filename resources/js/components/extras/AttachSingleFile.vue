<template>

    <div class="h-100 w-100" >


        <div class="jb-attached-file">
            <div class="image-display" v-if="imagePreview">
                <img :src="imagePreview" ref="image_display" class="img-fluid" alt="">
                <button type="button"
                        class="rounded-circle btn btn-primary"
                        style="width: 30px; height: 30px; text-align: center; padding: 0;"
                        @click="remove"
                        title="Remove file">x
                </button>
            </div>
            <div v-else class="dropzone has-text-centered" @dragover.prevent="dragover"
                 :class="dropAreaDragOver?'active':''"
                 @dragleave.prevent="dragleave" @drop.prevent="drop">
                <input type="file"
                       name="attachedFile"
                       id="assetsFieldHandle"
                       class="is-hidden "
                       @change="onFileInputChange" ref="file"
                       accept=".pdf,.jpg,.jpeg,.png"/>

                <label for="assetsFieldHandle"
                       class="text-center click-here">
                    <div>
                        <p class="t-meri m-0">
                            <span class=" t-4 t-orange"><b-icon icon="plus-circle"/></span>
                            <br>
                            Add File
                        </p>
                    </div>
                </label>

            </div>


            <!--                <div>-->
            <!--                    <ul class="mt-4 list-unstyled"-->
            <!--                        v-if="uploadedFileList.length">-->
            <!--                        <li class="text-sm p-1 d-flex justify-content-between"-->
            <!--                            v-for="file in uploadedFileList">-->

            <!--                            <div>-->
            <!--                                <p>-->
            <!--                                    <template-->
            <!--                                        v-if="['xlsx','docx'].includes(file.name.split('.').pop().toLowerCase() )">-->
            <!--                                        <img-->
            <!--                                            src="/images/file_type_icons/doc.svg"-->
            <!--                                            alt="" width="35">-->
            <!--                                    </template>-->
            <!--                                    <template v-else>-->
            <!--                                        <img-->
            <!--                                            :src="`/images/file_type_icons/${file.name.split('.').pop()}.svg`"-->
            <!--                                            alt="" width="35">-->
            <!--                                    </template>-->


            <!--                                    <span>-->
            <!--                                                                            {{ file.name }}-->
            <!--                                                                        </span>-->
            <!--                                </p>-->

            <!--                            </div>-->
            <!--                            <button type="button"-->
            <!--                                    class="rounded-circle btn btn-primary"-->
            <!--                                    style="width: 30px; height: 30px; text-align: center; padding: 0;"-->
            <!--                                    @click="remove(uploadedFileList.indexOf(file))"-->
            <!--                                    title="Remove file">x-->
            <!--                            </button>-->
            <!--                        </li>-->
            <!--                    </ul>-->
            <!--                </div>-->


        </div>
    </div>

</template>

<script>
    export default {
        name: "AttachSingleFile",
        props: {
            value: {
                type: File
            }
        },

        data() {
            return {
                uploadedFile: null,
                dropAreaDragOver: false,
                dropAreaDragLeave: false,
                imagePreview: null,
            }
        },

        methods: {
            onFileInputChange() {
                this.uploadedFile = this.$refs.file.files[0];
                this.$emit('input', this.uploadedFile);
                if (/\.(jpe?g|png|gif)$/i.test(this.uploadedFile.name)) {

                    let reader = new FileReader();

                    reader.addEventListener("load", () => {
                        this.imagePreview = reader.result;
                    }, false);

                    if (this.uploadedFile) {
                        reader.readAsDataURL(this.uploadedFile);
                    }
                }
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


            remove() {
                this.uploadedFile = null;
            },


        }
    }
</script>

<style scoped>

</style>
