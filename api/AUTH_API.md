# 用户认证 API 文档

## 概述
本 API 提供用户注册、登录和登出功能。

## 端点

### 1. 用户注册
**端点**: `POST /api/v1/register`

**请求体**:
```json
{
  "name": "用户名",
  "email": "user@example.com",
  "password": "password123",
  "password_confirmation": "password123"
}
```

**验证规则**:
- `name`: 必需，字符串，最大255字符
- `email`: 必需，有效邮箱格式，最大255字符，唯一
- `password`: 必需，字符串，最少8字符，需要确认
- `password_confirmation`: 必需，必须与password字段匹配

**成功响应** (201):
```json
{
  "success": true,
  "message": "注册成功",
  "data": {
    "user": {
      "id": 1,
      "name": "用户名",
      "email": "user@example.com",
      "created_at": "2025-12-26T06:00:00.000000Z",
      "updated_at": "2025-12-26T06:00:00.000000Z"
    },
    "access_token": "1|abc123...",
    "token_type": "Bearer"
  }
}
```

**失败响应** (422):
```json
{
  "success": false,
  "message": "验证失败",
  "errors": {
    "email": ["邮箱已被使用"]
  }
}
```

### 2. 用户登录
**端点**: `POST /api/v1/login`

**请求体**:
```json
{
  "email": "user@example.com",
  "password": "password123"
}
```

**验证规则**:
- `email`: 必需，有效邮箱格式
- `password`: 必需

**成功响应** (200):
```json
{
  "success": true,
  "message": "登录成功",
  "data": {
    "user": {
      "id": 1,
      "name": "用户名",
      "email": "user@example.com",
      "created_at": "2025-12-26T06:00:00.000000Z",
      "updated_at": "2025-12-26T06:00:00.000000Z"
    },
    "access_token": "2|def456...",
    "token_type": "Bearer"
  }
}
```

**失败响应** (401):
```json
{
  "success": false,
  "message": "邮箱或密码不正确"
}
```

### 3. 用户登出
**端点**: `POST /api/v1/logout`

**请求头**:
```
Authorization: Bearer {access_token}
```

**成功响应** (200):
```json
{
  "success": true,
  "message": "登出成功"
}
```

**失败响应** (401):
```json
{
  "message": "Unauthenticated."
}
```

## 使用示例

### 注册新用户
```bash
curl -X POST http://your-domain.com/api/v1/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "张三",
    "email": "zhangsan@example.com",
    "password": "password123",
    "password_confirmation": "password123"
  }'
```

### 登录
```bash
curl -X POST http://your-domain.com/api/v1/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "zhangsan@example.com",
    "password": "password123"
  }'
```

### 登出
```bash
curl -X POST http://your-domain.com/api/v1/logout \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer {your_access_token}"
```

## 安全特性

- 密码使用 bcrypt 算法加密存储
- 使用 Laravel Sanctum 进行 API 令牌认证
- 完整的输入验证防止恶意数据
- 邮箱唯一性验证防止重复注册
- 登出端点需要身份验证
