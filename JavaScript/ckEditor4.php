ckEditor4 
이미지 : 아이콘 클릭 > 업로드 버튼 > 파일선택 > 서버로 전송 > 제대로 저장 되었을 경우 자동으로 이미지 정보 화면으로 이동됨

<html>
  <head>
    <script src="https://cdn.ckeditor.com/4.9.2/standard-all/ckeditor.js"></script>
  </head>
  <body>
    문의 내용 : <textarea id='content' name="content" rows="10" cols="80"></textarea><br>

    <scirpt>
      CKEDITOR.replace('content',{
          filebrowserUploadUrl:'/vital/assoc/board/file.php',     // 이미지 업로드 기능 추가 : 파일 저장 경로
          height: 200,
          width:800
      });

      // CKeditor (이미지 속성 눌렀을 때 기능)
      CKEDITOR.on('dialogDefinition', function(e){
          var dialogName = e.data.name;
          var dialogDefinition = e.data.definition;

          switch(dialogName){
              case 'image':
                  // dialogDefinition.removeContents('info');      // 이미지 정보
                  dialogDefinition.removeContents('Link');          // 링크
                  dialogDefinition.removeContents('inadvanced');
                  break; 
          }
      })

      // 데이터 form으로 넘길 때 값
      contents = CKEDITOR.instances.content.getData();
      ㅡㅡㅡㅡ                       ㅡㅡㅡㅡ
        변수                       textarea ID
      </script>
  </body>
</html>

<php>

  // 파일 저장 이후 값 넘길 때
  echo ('{"filename" : "'.$insert_f[0]['rand'].'", "uploaded" : 1, "url":"'.$path.'"}');
  
</php>