let dropArea = document.getElementById('drop-area')

const handlerFunction = () => {
  console.log('Here');
}
  dropArea.addEventListener('dragenter', handlerFunction, false)
  dropArea.addEventListener('dragleave', handlerFunction, false)
  dropArea.addEventListener('dragover', handlerFunction, false)
  dropArea.addEventListener('drop', handlerFunction, false)
