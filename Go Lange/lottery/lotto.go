package main

import (
	"bufio"
	"os"
	"fmt"
	"math/rand"
	"strconv"
	"time"
)

func main() {
	// lottery.exe filename count 
	if len(os.Args) < 3 {
		fmt.Fprintln(os.Stderr, "Invalid arguments!\nlottery filename count")
		return

	}
	filename := os.Args[1]
	count, err := strconv.Atoi(os.Args[2])
	if err != nil {
		fmt.Fprintln(os.Stderr, "cannot convert count to integer! count:", count)
		return
	}

	candidates, err := readCandidates(filename)			// 파일에서 후보 목록
	if err != nil {		
		fmt.Fprintln(os.Stderr, "cannot read candidates file!", err)
		return
	}

	rand.Seed(time.Now().UnixNano())

	winners := make([]string, count)
	for i := 0; i < count; i++ {
		n := rand.Intn(len(candidates))			//Intn : 0에서 N 사이의 값
		winners[i] = candidates[n]
		candidates = append(candidates[:n], candidates[n+1:]...)		// [:n] : 시작부터 N까지 , candidates[n+1:]... : 다음에 당첨된 항목 제외

	}
	fmt.Println("Winners are")
	for _, winner := range winners {
		fmt.Println(winner)
	}
	
}

func readCandidates(filename string) ([]string, error) {
	file, err := os.Open(filename)
	if err != nil{
		return nil, err
	}
	defer file.Close()

	// 한 줄씩 읽기
	scanner := bufio.NewScanner(file)	
	var candidates []string
	for scanner.Scan() {
		candidates = append(candidates, scanner.Text())
	}
	return candidates, nil
}


