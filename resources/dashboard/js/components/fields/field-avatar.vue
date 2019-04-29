<template>
  <div class="one-field one-field-text" v-if="editing">
    <el-upload :show-file-list="false" :on-success="handleAvatarSuccess" class="avatar-uploader"></el-upload>
    <img v-if="input" :src="input" class="avatar" />
    <i v-else class="el-icon-plus avatar-uploader-icon"></i>
  </div>
  <div class="one-field one-field-text" v-else>{{ input }}</div>
</template>

<script>
import FormControl from "../../mixins/form-control"
export default {
  mixins: [FormControl],
  methods: {
    handleAvatarSuccess(res, file) {
      this.imageUrl = URL.createObjectURL(file.raw)
    },
    beforeAvatarUpload(file) {
      const isJPG = file.type === "image/jpeg"
      const isLt2M = file.size / 1024 / 1024 < 2

      if (!isJPG) {
        this.$message.error("上传头像图片只能是 JPG 格式!")
      }
      if (!isLt2M) {
        this.$message.error("上传头像图片大小不能超过 2MB!")
      }
      return isJPG && isLt2M
    }
  }
}
</script>

<style scoped lang="scss">
.avatar-uploader .el-upload {
  border: 1px dashed #d9d9d9;
  border-radius: 6px;
  cursor: pointer;
  position: relative;
  overflow: hidden;
}
.avatar-uploader .el-upload:hover {
  border-color: #409eff;
}
.avatar-uploader-icon {
  font-size: 28px;
  color: #8c939d;
  width: 178px;
  height: 178px;
  line-height: 178px;
  text-align: center;
}
.avatar {
  width: 178px;
  height: 178px;
  display: block;
}
</style>
