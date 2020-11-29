<template>

    <div>

        <label class=" t-mont t-bold">
            <b-icon icon="paperclip" type="is-primary" size=""/>
            Attach
            Necessary Files(Optional)</label>


        <div class="jb-attached-files">
            <div class="dropzone" @dragover.prevent="dragover"
                 :class="dropAreaDragOver?'active':''"
                 @dragleave.prevent="dragleave" @drop.prevent="drop">
                <input type="file" multiple
                       name="fields[assetsFieldHandle][]"
                       id="assetsFieldHandle"
                       class="d-none "
                       @change="onFileInputChange" ref="file"
                       accept=".pdf,.jpg,.jpeg,.png"/>

                <label for="assetsFieldHandle"
                       class="text-center click-here">
                    <div>
                        <p class="t-meri m-0">Drag or drop files here or
                            <span
                                class="underline">click here</span></p>
                        <p class="t-meri m-0">to select</p>
                    </div>
                </label>

            </div>


            <div>
                <ul class="mt-4 list-unstyled"
                    v-if="uploadedFileList.length">
                    <li class="text-sm p-1 d-flex justify-content-between"
                        v-for="file in uploadedFileList">

                        <div>
                            <p>
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


                                <span>
                                                                            {{ file.name }}
                                                                        </span>
                            </p>

                        </div>
                        <button type="button"
                                class="rounded-circle btn btn-primary"
                                style="width: 30px; height: 30px; text-align: center; padding: 0;"
                                @click="remove(uploadedFileList.indexOf(file))"
                                title="Remove file">x
                        </button>
                    </li>
                </ul>
            </div>


        </div>
    </div>

</template>

<script>
    export default {
        name: "AttachFiles",
        props: {
            value: {
                type: Array
            }
        },

        data() {
            return {
                uploadedFileList: [],
                dropAreaDragOver: false,
                dropAreaDragLeave: false,
            }
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

            resetProject() {
                this.project = {
                    title: '',
                    description: '',
                    category: '',
                    budget: '',
                    minimumBid: '',
                    maximumBid: '',
                    extraRequirements: '',
                }
            },

        }
    }
</script>

<style scoped>

</style>
