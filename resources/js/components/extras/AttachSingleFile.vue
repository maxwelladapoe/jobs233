<template>

    <div class="h-100 w-100" >


        <div class="jb-attached-file">
            <div class="image-display" v-if="imagePreview">
                <img :src="imagePreview" ref="image_display" class="img-fluid" alt="">
                <button type="button"
                        class="delete"
                        @click="remove"
                        title="Remove file"/>
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
