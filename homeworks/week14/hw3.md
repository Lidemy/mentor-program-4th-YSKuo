## 什麼是 DNS？Google 有提供的公開的 DNS，對 Google 的好處以及對一般大眾的好處是什麼？

### DNS
DNS 作為將域名和IP位址相互對映的一個分散式資料庫，能夠使人更方便地存取網際網路。

DNS 就是類似手機裡的 `聯絡人`，每當你要打電話給你的朋友，你可以拿起手機直接撥打他的 `電話號碼`；或是點選手機聯絡人中他的 `名字`，那你的手機就會透過已記錄的 `電話號碼` 來撥號。DNS 利用類似的概念，當你想要瀏覽一個網站（例如 Google），你可以直接輸入該網站的 `IP 位址`（Google 的 IP 位址為 `8.8.8.8`），或是在瀏覽器網址列輸入的 `Domain name`（輸入 `www.google.com`），那你的瀏覽器就會透過 DNS 幫你連接到該網站。

### DNS 對 Google 與大眾的好處
大眾可以使用 Google 提供的 DNS 來更方便（快速）連線
Google 則可透過大眾使用 DNS 來搜集使用者數據，這些數據可方便他們投放精準廣告

## 什麼是資料庫的 lock？為什麼我們需要 lock？

多筆 transaction 同時進行時，可能會互相影響而造成違反 concurrency 和 isolation 的狀況，因此需在 transaction 進行時把被影響的資料 lock 住，其他 transaction 就不能在同時間針對那些資料 read/write。

## NoSQL 跟 SQL 的差別在哪裡？

* SQL 關聯式資料語言 *(**S**tructured **Qu**ery **L**anguage)*
  * 是一種專門拿來操作關聯式資料庫的程式語言，簡單來說就是用指令去操作資料庫
  * 其中比較有名的系統是 MySQL 與 PostgreSQL
  * 常見組合 LAMP: Linux, Apache, MySQL (SQL), PHP

* NoSQL 非關聯式資料語言 *(**N**ot **O**nly SQL)*
  * 相較於 SQL 只能儲存單一型態的資料，NoSQL 可以儲存的資料更複雜一些，常用於存 log 日誌
  * 用 key-value 來存資料，可以想成存 JSON 進 DB
  * 比較有名的系統是 MongoDB
  * 常見組合 MEAN: MongoDB (NoSQL), Express, Angular, Node.js

### 其他比較

- SQL Table vs NoSQL Documents
  - SQL 用 table 存資料
  - NoSQL 用類似 JSON 的 document 存資料
- SQL Normalization vs NoSQL Denormalization
  - SQL 會使用 JOIN 來互相參照其他 table 而達到
  - NoSQL 將資料都存在同一筆資訊中，因此 NoSQL 的 query 速度往往比 SQL 快
- Schema
  - SQL 必須先定義 schema 才能存資料，因此資料更有規則而比起 NoSQL 好管理
  - NoSQL 沒 schema，優點是比較彈性，若要新增欄位則不用去更改資料庫設計，更適合初始階段難以定義資料庫格式的專案

##### 參考
1. [深入浅出 SQL(中文版)](https://github.com/wqinc/eBook/blob/master/%E6%B7%B1%E5%85%A5%E6%B5%85%E5%87%BA%20SQL(%E4%B8%AD%E6%96%87%E7%89%88).pdf)
1. [了解NoSQL不可不知的5項觀念](https://www.ithome.com.tw/news/92506)
1. [SQL vs NoSQL: The Differences](https://www.kshuang.xyz/doku.php/database:sql_vs_nosql)
1. [閃開！讓專業的來：SQL 與 NoSQL](https://ithelp.ithome.com.tw/articles/10187443)

## 資料庫的 ACID 是什麼？

![](https://i.imgur.com/bz3MKoj.png)

確保 transaction 的正確性，須符合以下特性
- Atomicity 原子性
  - 表示每個 transaction 都像原子一樣，不可再分割
  - 換句話說，一個 transaction 所有動作，最終將全部成功或全部失敗
  - 如果執行過程發生錯誤，就會 rollback 到 transaction 開始前的狀態
- Consistency 一致性
  - 維持資料的一致性
  - 保證 transaction 讓 database 從一個 valid 的狀態移轉到另個 valid 的狀態
  - 例：限制錢的總數一致或是限制帳戶餘額扣款後不得為負數，滿足這些限制的 transaction 才是合格也才符合一致性
- Isolation 隔離性
  - 多筆 transaction 不互相影響，亦即不能同時更改同一個值
- Durability 持久性
  - transaction 成功後，寫入的資料不會消失
  - 若 commit 的過程中系統發生錯誤，則系統回復之後要繼續完成未完成的工作

##### 參考
1. [資料庫ACID](https://dotblogs.com.tw/rockchang/2014/05/05/144972)
1. [如何理解数据库事务中的一致性的概念？](https://www.zhihu.com/question/31346392)
1. [Database Transaction第一話: ACID](http://karenten10-blog.logdown.com/posts/192629-database-transaction-1-acid)