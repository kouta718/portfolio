// 既存の別名の数を取得
let toolNameIndex = Number(
    document.getElementById('tool-names-container').dataset.count || 0
);

//フォーム追加
document.getElementById('add-tool-name-button').addEventListener('click', () => {
    addToolName();
});

function addToolName() {
    toolNameIndex++;

    const template = document.getElementById('tool-name-template');
    const clone = template.content.cloneNode(true);

    // 名前の index を置き換え
    clone.innerHTML = clone.innerHTML?.replaceAll('__index__', toolNameIndex);

    document.getElementById('tool-names-container').appendChild(clone);
}

//削除ボタン
document.addEventListener('click', (e) => {
    //ボタンターゲットをのフォームを削除
    if (e.target.classList.contains('remove-tool-name')) {
        e.target.closest('.tool-name-item').remove();
    }
});