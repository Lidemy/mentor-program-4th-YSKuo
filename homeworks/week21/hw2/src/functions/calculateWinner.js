export default (board) => {
  // 檢查橫排
  for (let i = 0; i < 19; i++) {
    for (let j = 0; j <= 13; j++) {
      if (board[i][j]["value"]) {
        if (
          board[i][j]["value"] === board[i][j+1]["value"] &&
          board[i][j+1]["value"] === board[i][j+2]["value"] &&
          board[i][j+2]["value"] === board[i][j+3]["value"] &&
          board[i][j+3]["value"] === board[i][j+4]["value"]
        ) {
          console.log(board[i][j]["value"], '橫排贏');
          return board[i][j]["value"]
        }
      }
    }
  }

  // 檢查直排
  for (let i = 0; i <= 13; i++) {
    for (let j = 0; j < 19; j++) {
      if (board[i][j]["value"]) {
        if (
          board[i][j]["value"] === board[i+1][j]["value"] &&
          board[i+1][j]["value"] === board[i+2][j]["value"] &&
          board[i+2][j]["value"] === board[i+3][j]["value"] &&
          board[i+3][j]["value"] === board[i+4][j]["value"]
        ) {
          console.log(board[i][j]["value"], '直排贏');
          return board[i][j]["value"]
        }
      }
    }
  }

  // 檢查左上連右下
  for (let i = 0; i <= 14; i++) {
    for (let j = 0; j <= 14; j++) {
      if (board[i][j]["value"]) {
        if (
          board[i][j]["value"] === board[i+1][j+1]["value"] &&
          board[i+1][j+1]["value"] === board[i+2][j+2]["value"] &&
          board[i+2][j+2]["value"] === board[i+3][j+3]["value"] &&
          board[i+3][j+3]["value"] === board[i+4][j+4]["value"]
        ) {
          console.log(board[i][j]["value"], '左上連右下贏');
          return board[i][j]["value"]
        }
      }
    }
  }

  // 檢查右上連左下
  for (let i = 4; i < 19; i++) {
    for (let j = 0; j <= 14; j++) {
      if (board[i][j]["value"]) {
        if (
          board[i][j]["value"] === board[i-1][j+1]["value"] &&
          board[i-1][j+1]["value"] === board[i-2][j+2]["value"] &&
          board[i-2][j+2]["value"] === board[i-3][j+3]["value"] &&
          board[i-3][j+3]["value"] === board[i-4][j+4]["value"]
        ) {
          console.log(board[i][j]["value"], '右上連左下贏');
          return board[i][j]["value"]
        }
      }
    }
  }
};