System Helper
===

# 說明
提供系統操作方面的輔助函式庫


# 需求
- Cookie操作簡化
  - 類似jQuery cookie把參數使用陣列傳入
  - 使用常數以簡化設定，生效優先序: 輸入 => 常數 => 預設值
  - 一般操作函式與根網域操作函式
    > 目前網域與根網域有同名稱變數時，優先讀取目前網域資料

# 案例

# 影響

# 功能
## Cookie
### 設定Cookie
### 設定Cookie到根網域
### 讀取Cookie
### 刪除Cookie
### 刪除Cookie從根網域


# 流程

# 畫面

# 欄位

# 介面

# 結構
- doc
  - design.md
- example
  - example.php
- src
  - SystemHelper.php
- tests
  - SystemHelperTest.php
- .gitignore
- .travis.yml
- composer.json
- LICENSE
- phpunit.xml
- README.md

# 函式庫

# 工作項目
## Cookie
- 設定Cookie
- 設定Cookie到根網域
- 讀取Cookie
- 刪除Cookie
- 刪除Cookie從根網域


# 測試項目
## Cookie
- 設定Cookie
- 設定Cookie到根網域
- 讀取Cookie
- 刪除Cookie
- 刪除Cookie從根網域
- 參數設定
  - 有無設定常數效果測試
  - 參數優先序測試


# 問題&討論
## Cookie
- 目前網域與根網域有同名稱變數時，優先讀取目前網域資料

# 參考

# 記錄
- 20210424: MarsHung建立
- 20210424: MarsHung增加Cookie相關函式&測試