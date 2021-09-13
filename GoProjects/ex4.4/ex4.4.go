package main

import "fmt"

func main() {
	a := 3		// int - 54 bit = int64
	var b float64 = 3.5

	var c int = int(b)	// 3.5 -> 3으로 변환
	d := float64(a) * b

	var e int64 = 7
	f := a * int(e)

	fmt.Println(a,b,c,d,e,f)
}

// 타입이 다를 때 타입변환으로 인해 계산할 수 있다
