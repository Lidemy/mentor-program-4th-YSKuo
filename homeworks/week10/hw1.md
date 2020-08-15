## 六到十週心得與解題心得

### 心得
整理了一下心得在下面文章中
[1st 實習終結](https://medium.com/@crowley3141/1st-%E5%AF%A6%E7%BF%92%E7%B5%82%E7%B5%90-29a28c9a56e8)

### 綜合能力測驗
最後一個 `myMissingNumberToSetToMakeTheRequest` 有點摸不著頭緒，試著用 console 隨便輸入一個值得到
`{hint: "54ceb91256e8190e474aa752a6e0650a2df5ba37", error: "數字錯誤"}`
還沒接觸到 week11 內容一時間沒反應是啥，結果丟去估狗就知道是 hash 的範疇，最後把 reverse string 輸入就通關了～

### r3:0 異世界網站挑戰 
卡在 lv5 很久，想說直接跳到 lv6 應該就是 redirect，可是為啥 HTTP status 不是 3xx 呢，左思右想難道我哪邊搞錯...

後來看到 lv5.js 內容
`window.location='./lv6.php?token=fail';`
這才真正確認我沒想錯XDD
但是到底為啥 HTTP status 不是 3xx？求解惑

過了 lv5 這關之後就沒啥卡了，顏文字加密有意思但懶得解碼直接 window 找 token，最後一關原本想暴力解看看，但仔細一瞧覺得 token 很好湊出來，沒多久就過了～

