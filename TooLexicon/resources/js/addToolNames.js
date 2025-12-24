// 既存の別名の数を取得し、
// 新規追加時に index が連番になるよう初期値を調整
let toolNameIndex = Number(
    document.getElementById('tool-names-container').dataset.count || 0
);
toolNameIndex--;

//フォーム追加ボタン、クリックで実行
document.getElementById('add-tool-name-button').addEventListener('click', () => {
    addToolName();
});

// 別名入力フォームを1つ追加する処理
function addToolName() {
    toolNameIndex++;

    // template からフォームの雛形を複製
    const template = document.getElementById('tool-name-template');
    const clone = template.content.cloneNode(true);

    // DocumentFragmentの最初の要素を取得してouterHTMLで置換
    const firstElement = clone.firstElementChild;

    // __index__ をtoolNameIndexに置き換えたHTMLを生成
    let html = firstElement.outerHTML;
    html = html.replaceAll('__index__', toolNameIndex);

    // 新しい要素を作成
    const tempDiv = document.createElement('div');
    tempDiv.innerHTML = html;
    const newElement = tempDiv.firstElementChild;

    // DOMに作成した新しい要素を追加
    document.getElementById('tool-names-container').appendChild(newElement);
};

//削除ボタン
document.addEventListener('click', (e) => {
    //ボタンターゲットをのフォームを削除
    if (e.target.classList.contains('remove-tool-name')) {
        e.target.closest('.tool-name-item').remove();
    }
});