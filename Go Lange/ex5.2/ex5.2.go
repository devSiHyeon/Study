package main

import "fmt"

func main(){
	var a int = 10
	var b int = 20
	var f float64 = 32799438743.8287

	fmt.Print("a: ", a, "b: ",b)					// 입력값 사이에 공백이 없음
	fmt.Println("a: ", a, "b: ",b, "f: ", f)		// 입력값 사이에 공백을 자동으로 생성된다
	fmt.Printf("a: %d b: %d f: %f\n", a, b, f)		// 서식에 맞춰 정수타입을 출력된다 (%d : %뒤에 작성된문자는 서식문자라고 한다 = formatter)
}