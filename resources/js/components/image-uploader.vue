<template>
  <div class="image-uploader">
    <el-upload class="image-item-uploader" accept="image/png,image/jpeg,image/gif,image/bmp" action="/admin/files/upload?strategy=image"
               :show-file-list="false" :on-success="handleImageUploaded">
      <div class="text-center" v-if="url">
        <div class="flex justify-center items-center"><img :src="url" class="image-item"></div>
        <el-button size="mini" plain>重新选择</el-button>
      </div>
      <i v-else class="el-icon-plus image-item-uploader-icon"></i>
    </el-upload>
  </div>
</template>

<script>
  export default {
    props: ['value', 'fullUrl'],
    name: 'image-uploader',
    data() {
      return {
        url: this.value
      }
    },
    watch: {
      url() {
        this.$emit('input', this.url)
        this.$emit('change', this.url)
      },
      value() {
        if (this.value != this.url) {
          this.url = this.value
        }
      }
    },
    methods: {
      handleImageUploaded(response) {
        this.url = response.url
      }
    }
  }
</script>

<style lang="scss">
  .image-uploader {
    .image-item-uploader .el-upload {
      display: block;
      border: 1px dashed #d9d9d9;
      border-radius: 6px;
      cursor: pointer;
      position: relative;
      overflow: hidden;
    }
    .image-item-uploader .el-upload:hover {
      border-color: #409EFF;
    }
    .image-item-uploader-icon {
      font-size: 28px;
      color: #8c939d;
      /*width: 178px;*/
      height: 178px;
      line-height: 178px;
      text-align: center;
    }
    .image-item {
      /*width: 178px;*/
      height: 178px;
      display: block;
    }
  }
</style>
