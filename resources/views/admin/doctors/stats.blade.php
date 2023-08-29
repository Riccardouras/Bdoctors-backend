@extends('layouts.admin')

@section('content')
    <div class="container mt-3">
        <div class="row justify-content-center">
            <h1> Ciao {{ $user->name }}</h1>

            <div class="col-6">
                <h3>VOTI ULTIMO MESE</h3>
                <canvas id="monthlyVote"></canvas>
            </div>
    
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
            <script>
                const monthlyVote = document.getElementById('monthlyVote');
    
                new Chart(monthlyVote, {
                    type: 'bar',
                    data: {
                    labels: ['1', '2', '3', '4', '5'],
                    datasets: [{
                        label: 'Numero di voti',
                        data: [{{ $lastMonthVotes['oneStar'] }}, {{ $lastMonthVotes['twoStar'] }},{{ $lastMonthVotes['threeStar'] }},{{ $lastMonthVotes['fourStar'] }},{{ $lastMonthVotes['fiveStar'] }},],
                        borderWidth: 1
                    }]
                    },
                    options: {
                    scales: {
                        y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                        }
                    }
                    }
                });
            </script>
    
            <div class="col-6">
                <h3>VOTI ULTIMO ANNO</h3>
                <canvas id="yearlyVote"></canvas>
            </div>
    
    
            <script>
                const yearlyVote = document.getElementById('yearlyVote');
    
                new Chart(yearlyVote, {
                    type: 'bar',
                    data: {
                    labels: ['1', '2', '3', '4', '5'],
                    datasets: [{
                        label: 'Numero di voti',
                        data: [{{ $lastYearVotes['oneStar'] }}, {{ $lastYearVotes['twoStar'] }},{{ $lastYearVotes['threeStar'] }},{{ $lastYearVotes['fourStar'] }},{{ $lastYearVotes['fiveStar'] }},],
                        borderWidth: 1
                    }]
                    },
                    options: {
                    scales: {
                        y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                        }
                    }
                    }
                });
            </script>
        </div>

        
    </div>
@endsection
